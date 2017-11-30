<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-14
 * Time: 14:21
 */

namespace sunsun\server\business;

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
#declare(ticks=1);

date_default_timezone_set("Etc/GMT");
// 外部没有定义过则默认正式环境
if (!defined('SUNSUN_ENV')) {
    define("SUNSUN_ENV", "production");//debug|production 模式
}

use GatewayWorker\Lib\Gateway;
use sunsun\dal\DeviceTcpClientDal;
use sunsun\decoder\SunsunTDS;
use sunsun\model\DeviceTcpClientModel;
use sunsun\server\consts\SessionKeys;
use sunsun\server\consts\SunsunDeviceConstant;
use sunsun\server\db\DbPool;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\server\tcpChannelCommand\CommandFactory;
use sunsun\transfer_station\client\FactoryClient;
use sunsun\transfer_station\client\TransferClient;
use Workerman\Lib\Timer;
use Workerman\Worker;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * @var  \sunsun\server\db\DbPool
     */
    public static $dbPool;
    private static $activeTime;//

    public static function onWorkerStart(Worker $businessWorker)
    {
        self::$dbPool = DbPool::getInstance();
        // 只在worker 0 中设置检测定时器
        if ($businessWorker->id == 0) {
            self::checkOfflineSession();
        }
    }

    /**
     * 检测离线的会话，并断开该通道
     *
     */
    private static function checkOfflineSession()
    {
        Timer::add(SunsunDeviceConstant::CHECK_OFFLINE_SESSION_INTERVAL, function () {

            $allSessions = Gateway::getAllClientSessions();
            $now = time();
            foreach ($allSessions as $client_id => $session) {

                if (array_key_exists(SessionKeys::LAST_ACTIVE_TIME, $session)) {
                    $last_active_time = $session[SessionKeys::LAST_ACTIVE_TIME];
                    if ($now - $last_active_time >= SunsunDeviceConstant::DEVICE_OFFLINE_TIME_INTERVAL) {
                        Gateway::closeClient($client_id);
                        continue;
                    }
                }

                if (is_array($session) && array_key_exists(SessionKeys::DID, $session)) {

                    $pwd = '';
                    if (array_key_exists(SessionKeys::PWD, $session)) {
                        $pwd = $session[SessionKeys::PWD];
                    }
                    $did = $session[SessionKeys::DID];
                    $cnt = TransferClient::totalClientByGroup($did);
                    // 只有有设备连接的时候才调用获取设备信息
                    if ($cnt > 0) {
                        FactoryClient::getInfo($client_id, $did, $pwd);
                    }

                    // 2. 更新会话信息
                    Gateway::updateSession($client_id, ['app_cnt' => $cnt]);
                }
            }
        });
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     */
    public static function onMessage($client_id, $message)
    {
        if (empty($message) || !is_string($message)) {
            return;
        }
        self::$activeTime = time();
        // 处理外部加载的指令
        self::acceptCommand($client_id);
        if (self::isLoginRequest()) {
            //第一次请求
            $pwd = Password::getSecretKey(Password::TYPE_LOGIN, $client_id);
            $result = self::login($client_id, $message, $pwd);
        } else {
            // 1. 获取密钥
            $result = Password::getSecretKey(Password::TYPE_OTHER, $client_id);
            if ($result === false) {
                self::jsonError($client_id, "get encrypt password failed", null);
                return;
            }
            $pwd = $result[SessionKeys::PWD];
            $did = $result[SessionKeys::DID];
            $result = SunsunTDS::decode($message, $pwd);
            if (empty($result)) {
                self::jsonError($client_id, 'fail decode the data ', []);
                return;
            }
            if (!$result->isValid()) {
                self::jsonError($client_id, 'the data format is invalid', []);
                return;
            }
            // 3. 处理业务逻辑
            $result = self::process($did, $client_id, $result->getTdsOriginData());
        }

        // 这个必须，用于处理有些请求不返回信息的情况
        // 目前只有心跳
        if (empty($result)) {
            return;
        }

        if (method_exists($result, "toDataArray")) {
            $data = $result->toDataArray();
            // 4. 加密数据
            $encodeData = SunsunTDS::encode($data, $pwd);
            self::jsonSuc($client_id, serialize($result), $encodeData);
        } else {
            self::jsonError($client_id, 'fail', []);
        }

        return;
    }

    /**
     * 处理指令
     * @param $client_id
     */
    public static function acceptCommand($client_id)
    {
        // TODO: 增加其它指令
        if (array_key_exists('cmd_type', $_SESSION)) {
            $cmdType = $_SESSION['cmd_type'];
            // 创建指令
            $command = CommandFactory::create($cmdType);
            // 设置参数
            $params = ['client_id' => $client_id];
            // 加载参数
            $command->acceptParams($params);
            // 执行指令
            $command->execute();
        }
    }

    //============================帮助方法

    /**
     * 该次请求是否作为登录请求处理
     * @return bool
     */
    protected static function isLoginRequest()
    {
        if (!array_key_exists(SessionKeys::IS_FIRST, $_SESSION)) {
            $_SESSION[SessionKeys::IS_FIRST] = 0;
        }
        return $_SESSION[SessionKeys::IS_FIRST] == 0;
    }

    /**
     * 设备登录
     * @param $client_id
     * @param $message
     * @param $pwd
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\adt\resp\AdtHbResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\aq806\resp\Aq806HbResp|\sunsun\filter_vat\resp\FilterVatCtrlDeviceResp|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|\sunsun\filter_vat\resp\FilterVatDeviceInfoResp|\sunsun\filter_vat\resp\FilterVatDeviceUpdateResp|\sunsun\filter_vat\resp\FilterVatHbResp|\sunsun\filter_vat\resp\FilterVatLoginResp|\sunsun\water_pump\resp\WaterPumpCtrlDeviceResp|\sunsun\water_pump\resp\WaterPumpDeviceInfoResp|\sunsun\water_pump\resp\WaterPumpDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpHbResp
     */
    private static function login($client_id, $message, &$pwd)
    {
        $result = SunsunTDS::decode($message, $pwd);
        if ($result == null) {

            self::jsonError($client_id, 'decode fail', []);
            return null;
        }
        if (!$result->isValid()) {
            self::jsonError($client_id, 'the data format is invalid' . $message, []);
            return null;
        }
        //{"reqType": "1","sn": "0","did": "10000001","ver": "V1.0","pwd": "gigw+DAcMITN4SuEe6JmkA=="}
        $originData = $result->getTdsOriginData();

        $data = json_decode($originData, JSON_OBJECT_AS_ARRAY);
        if (!array_key_exists('did', $data) || empty($data[SessionKeys::DID])) {
            self::jsonError($client_id, 'the did is need', []);
            return null;
        }
        //2. Device 这里替换成具体设备的请求工厂类
        $did = $data[SessionKeys::DID];
        $req = DeviceFacadeFactory::createLoginReq($did, $data);
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        if ($dal == null) {
            self::jsonError($client_id, 'did invalid' . $did . 'is not exists', []);
            return null;
        }
        $result = $dal->getInfoByDid($did);
        if (empty($result)) {
            self::jsonError($client_id, 'which did=' . $did . 'is not exists', []);
            return null;
        }

        $id = $result['id'];
        $pwd = $result[SessionKeys::PWD];
        $hb = $result['hb'];//心跳周期（单位：秒）
        $originPwd = SunsunTDS::isLegalPwd($data[SessionKeys::PWD], $pwd);
        if (empty($originPwd)) {
            self::jsonError($client_id, $data[SessionKeys::PWD] . 'the control password decode fail,key=' . $pwd, []);
            return null;
        }

        $data['origin_pwd'] = $originPwd;
        //更新控制密码
        $ver = $req->getVer();
        $entity = [
            'ver' => $ver,
            'ctrl_pwd' => $originPwd,
            'last_login_time' => self::$activeTime,
            'update_time' => self::$activeTime,
            'last_login_ip' => self::getClientIp(),
            'tcp_client_id' => $client_id,
            'offline_notify' => 1,
        ];
        // 部分设备有这个device_type 参数
        if (method_exists($req, 'getType')) {
            $type = $req->getType();
            $entity['device_type'] = $type;
        }
        $dal->update($id, $entity);
        self::loginSuccess($client_id, $did);
        // 设置did,pwd
        $_SESSION[SessionKeys::DID] = $did;
        // 存在session中 就不需要再到数据库查询一次了
        $_SESSION[SessionKeys::PWD] = $pwd;
        //设置返回响应包
        //3. Device 这里替换成具体设备的登录响应类
        $resp = DeviceFacadeFactory::createLoginResp($did);
        $resp->setServerInfo($result);
        $resp->setSn($req->getSn());
        $resp->setLoginSuccess();
        $resp->setHb($hb);
        //绑定did 和 client_id
        Gateway::bindUid($client_id, $did);
        // 同一种类型的did，分配到同一个组，用于查询在线的设备，不同类型
        $group = substr($did, 0, 3);
        Gateway::joinGroup($client_id, $group);
        $loginMsg = 'did= ' . $did . ',ip= ' . self::getClientIp();
        return $resp;
    }

    /**
     * 返回错误信息
     * @param $client_id
     * @param $msg
     * @param $data
     */
    private static function jsonError($client_id, $msg, $data = [])
    {
        self::closeChannel($client_id, $msg);
    }

    /**
     * 关闭
     * @param $client_id
     * @param $closeMsg
     */
    private static function closeChannel($client_id, $closeMsg = '')
    {
        //3. tcp通道关闭
        Gateway::closeClient($client_id);
    }

    /**
     * 获取客服端ip
     * @return string
     */
    private static function getClientIp()
    {
        if ($_SERVER && array_key_exists("REMOTE_ADDR", $_SERVER)) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return "";
    }

    /**
     * 登录成功后进行操作
     * @param $client_id
     * @param $did
     */
    private static function loginSuccess($client_id, $did)
    {
        // 表示该设备已经登录过了，之后的请求走另一个处理方式
        $_SESSION[SessionKeys::IS_FIRST] = 1;
        $dal = new DeviceTcpClientDal(DbPool::getInstance()->getGlobalDb());
        $result = $dal->getInfoByDid($did);
        if (empty($result)) {
            // insert
            $po = new  DeviceTcpClientModel();
            $po->setDid($did);
            $po->setTcpClientId($client_id);
            $po->setPrevLoginTime(time());
            $dal->insert($po);
        } else {
            // update
            $dal->updateByDid($did, ['tcp_client_id' => $client_id, 'prev_login_time' => time()]);
        }
    }

    private static function process($did, $clientId, $originData)
    {
        $_SESSION[SessionKeys::LAST_ACTIVE_TIME] = self::$activeTime;
        $jsonDecode = json_decode($originData, JSON_OBJECT_AS_ARRAY);
        // 根据did 这里替换成具体设备的process类
        $action = DeviceFacadeFactory::createProcessAction($did);
        if($action != null) {
            $resp = $action->process($did, $clientId, $jsonDecode);
            return $resp;
        }
        return null;
    }

    /**
     * 返回正确信息
     * @param $client_id
     * @param $msg
     * @param $data
     */
    private static function jsonSuc($client_id, $msg, $data)
    {
        Gateway::sendToClient($client_id, $data);
    }

    /**
     * 获取数据库链接
     * @param $client_id
     * @return \sunsun\server\db\DbPool
     */
    public static function getDb($client_id = '')
    {
        if (!empty($client_id)) {
            $session = Gateway::getSession($client_id);
            if (array_key_exists('did', $session)) {
                $did = $session['did'];
                return DbPool::getInstance()->getDb($did);
            }
        }
        return DbPool::getInstance()->getGlobalDb();
    }

    /**
     * 当客户端断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        $session = $_SESSION;
        if (is_array($session) && array_key_exists(SessionKeys::DID, $session)) {
            $did = $session[SessionKeys::DID];
        }
        if(empty($did)){
            $result = (new  DeviceTcpClientDal(DbPool::getInstance()->getGlobalDb()))->getInfoByClientId($client_id);
            if(is_array($result) && array_key_exists(SessionKeys::DID, $result)) {
                $did = $result[SessionKeys::DID];
            }
        }
        if (!empty($did)) {
            DeviceFacadeFactory::getDeviceDal($did)->logoutByClientId($client_id);
        }
        Gateway::closeClient($client_id);
    }

}