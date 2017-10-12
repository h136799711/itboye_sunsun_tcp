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
define("CommonPassword", "1234bcda");//

use GatewayWorker\Lib\Gateway;
use sunsun\dal\DeviceTcpClientDal;
use sunsun\decoder\SunsunTDS;
use sunsun\model\DeviceTcpClientModel;
use sunsun\server\consts\SessionKeys;
use sunsun\server\db\DbPool;
use sunsun\server\device\DeviceFactory;
use sunsun\transfer_station\client\FactoryClient;
use sunsun\transfer_station\client\TransferClient;
use Workerman\Lib\Timer;

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
    const CHECK_OFFLINE_SESSION_INTERVAL = 3;// 检测离线通道的间隔时间 单位 秒

    public static function onWorkerStart($businessWorker)
    {
        self::$dbPool = DbPool::getInstance();
        self::checkOfflineSession();
    }

    /**
     * 检测离线的会话，并断开该通道
     *
     */
    private static function checkOfflineSession()
    {

        Timer::add(self::CHECK_OFFLINE_SESSION_INTERVAL, function () {
            try {
                $allSessions = Gateway::getAllClientSessions();
                $now = time();
                $offlineMinus = 2 * 120;// 离线4分钟以上
                foreach ($allSessions as $client_id => $session) {

                    if (array_key_exists(SessionKeys::LAST_ACTIVE_TIME, $session)) {
                        $last_active_time = $session[SessionKeys::LAST_ACTIVE_TIME];
                        if ($now - $last_active_time >= $offlineMinus) {
                            Gateway::closeClient($client_id);
                            DebugHelper::debug('[closeClient] client_id=' . $client_id, $session);
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
                        if ($cnt > 0) {
                            // 1. 仅当链接数大于0时，才向设备请求获取设备信息
                            DebugHelper::debug('[get_info] device = ' . $did, $session);
                            FactoryClient::getInfo($client_id, $did, $pwd);
                        }

                        DebugHelper::debug('[session] online app count= ' . $cnt, $session);
                        // 2. 更新会话信息
                        Gateway::updateSession($client_id, ['app_cnt' => $cnt]);
                    }
                }
            } catch (\Exception $ex) {
                DebugHelper::error('[checkOfflineSession]' . $ex->getMessage());
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
     * 处理指令
     * @param $client_id
     */
//    public static function acceptCommand($client_id){
//        // TODO: 重构
//        if (array_key_exists('cmd_type', $_SESSION)) {
//            $cmdType = $_SESSION['cmd_type'];
//            // 创建指令
//            $command = CommandFactory::create($cmdType);
//            // 设置参数
//            $params = ['client_id'=>$client_id];
//            // 加载参数
//            $command->acceptParams($params);
//            // 执行指令
//            $command->execute();
//        }
//    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     */
    public static function onMessage($client_id, $message)
    {
        try {
            if (empty($message) || !is_string($message)) {
//                DebugHelper::debug('[device tcp channel no message]', $_SESSION);
                return;
            }
            self::$activeTime = time();
            // 处理外部加载的指令
//            self::acceptCommand($client_id);
            $pwd = "";
            if (self::isLoginRequest()) {
                DebugHelper::debug('[device login start]' . $client_id, $_SESSION);
                //第一次请求
                $pwd = CommonPassword;
                $result = self::login($client_id, $message, $pwd);
                DebugHelper::debug('[device login end]' . $client_id, $_SESSION);
            } else {
                //其它请求
                DebugHelper::debug('[device other message process]', $_SESSION);
                // 1. 获取密钥
                $result = self::getEncryptPwd($client_id);
                if ($result === false) {
                    self::jsonError($client_id, "get encrypt password failed", null);
                    return;
                }
                $pwd = $result[SessionKeys::PWD];
                $did = $result['did'];
                DebugHelper::debug('[device other message process]did=' . $did . 'pwd=' . $pwd, $_SESSION);
                $result = SunsunTDS::decode($message, $pwd);
                if (empty($result)) {
                    self::jsonError($client_id, 'fail decode the data ', []);
                    return;
                }
                if (!$result->isValid()) {
                    self::jsonError($client_id, 'the data format is invalid', []);
                    return;
                }
                DebugHelper::debug('[device other message process]message=', $_SESSION);
                // 3. 处理业务逻辑
                $result = self::process($did, $client_id, $result->getTdsOriginData());
            }

            // 这个必须，用于处理有些请求不反回信息的情况
            if (empty($result)) {
                DebugHelper::debug('[device other message process] no response', $_SESSION);
                return;
            }

            if (method_exists($result, "toDataArray")) {
                $data = $result->toDataArray();
                DebugHelper::debug('[device other message process] response' . json_encode($data), $_SESSION);
                // 4. 加密数据
                $encodeData = SunsunTDS::encode($data, $pwd);
                self::jsonSuc($client_id, serialize($result), $encodeData);
            } else {
                DebugHelper::debug('[device other message process] fail, result has not method toDataArray', $_SESSION);
                self::jsonError($client_id, 'fail', []);
            }


        } catch (\Exception $ex) {
            //DebugHelper::debug('[device message process] exception'.$ex->getMessage(), $_SESSION);
//            LogHelper::log(self::$dbPool->getGlobalDb(),'-10',$ex->getMessage(),'error');
            self::jsonError($client_id, $ex->getMessage(), []);
        }
        return;
    }

    //============================帮助方法

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
                return self::$dbPool->getDb($did);
            }
        }
        return self::$dbPool->getGlobalDb();
    }

    /**
     * 返回错误信息
     * @param $client_id
     * @param $msg
     * @param $data
     */
    private static function jsonError($client_id, $msg, $data=[])
    {
        self::closeChannel($client_id, $msg);
    }

    /**
     * 关闭
     * @param $client_id
     * @param $closeMsg
     */
    private static function closeChannel($client_id, $closeMsg='')
    {
        //3. tcp通道关闭
        Gateway::closeClient($client_id);
    }

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
     * @return bool|\sunsun\water_pump\resp\WaterPumpLoginResp
     */
    private static function login($client_id, $message, &$pwd)
    {

        DebugHelper::debug('[device login] start decode message', $_SESSION);
        $result = SunsunTDS::decode($message, $pwd);
        if ($result == null) {
            DebugHelper::debug('[device login]  decode fail', $_SESSION);
            self::jsonError($client_id, 'decode fail', []);
            return false;
        }
        if (!$result->isValid()) {
            DebugHelper::debug('[device login]  decode success but data invalid', $_SESSION);
            self::jsonError($client_id, 'the data format is invalid' . $message, []);
            return false;
        }
        //{"reqType": "1","sn": "0","did": "10000001","ver": "V1.0","pwd": "gigw+DAcMITN4SuEe6JmkA=="}
        $originData = $result->getTdsOriginData();

        DebugHelper::debug('[device login] decode success message = ', $_SESSION);
        $data = json_decode($originData, JSON_OBJECT_AS_ARRAY);
        if (!array_key_exists('did', $data) || empty($data[SessionKeys::DID])) {
            DebugHelper::debug('[device login] did is missing', $_SESSION);
            self::jsonError($client_id, 'the did is need', []);
            return false;
        }
        //2. Device 这里替换成具体设备的请求工厂类
        $did = $data[SessionKeys::DID];
        $req = DeviceFactory::createLoginReq($did, $data);
        $dal = DeviceFactory::getDeviceDal($did);
        $result = $dal->getInfoByDid($did);
        if (empty($result)) {
            DebugHelper::debug('[device login] did[' . $did . '] is not exists', $_SESSION);
            self::jsonError($client_id, 'which did=' . $did . 'is not exists', []);
            return false;
        }

        $id = $result['id'];
        $pwd = $result[SessionKeys::PWD];
        $hb = $result['hb'];//心跳周期（单位：秒）
        $originPwd = SunsunTDS::isLegalPwd($data[SessionKeys::PWD], $pwd);
        if (empty($originPwd)) {

            DebugHelper::debug('[device login] the control password decode fail. encode pwd= ' . $data[SessionKeys::PWD] . ', key = ' . $pwd, $_SESSION);
            self::jsonError($client_id, $data[SessionKeys::PWD] . 'the control password decode fail,key=' . $pwd, []);
            return false;
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
        // 设置did,pwd,is_first
        $_SESSION[SessionKeys::DID] = $did;
        // 存在session中 就不需要再到数据库查询一次了
        $_SESSION[SessionKeys::PWD] = $pwd;
        // 表示该设备已经登录过了，之后的请求走另一个处理方式
        $_SESSION[SessionKeys::IS_FIRST] = 1;
        self::loginSuccess($client_id, $did);
        //设置返回响应包
        //3. Device 这里替换成具体设备的登录响应类
        $resp = DeviceFactory::createLoginResp($did);
        $resp->setSn($req->getSn());
        $resp->setLoginSuccess();
        $resp->setHb($hb);
        //绑定did 和 client_id
        Gateway::bindUid($client_id, $did);
        // 同一种类型的did，分配到同一个组，用于查询在线的设备，不同类型
        $group = substr($did, 0, 3);
        Gateway::joinGroup($client_id, $group);
        DebugHelper::debug('[device login] success', $_SESSION);
        return $resp;
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

    /**
     * 获取加密密钥
     * @param $client_id
     * @return array|bool
     * @internal param $result
     */
    private static function getEncryptPwd($client_id)
    {
        $session = Gateway::getSession($client_id);
        $result = false;
        if (array_key_exists(SessionKeys::DID, $session)) {
            $did = $session[SessionKeys::DID];
            if (array_key_exists(SessionKeys::PWD, $session)) {
                $pwd = $session[SessionKeys::PWD];
                $result = [SessionKeys::DID => $did, SessionKeys::PWD => $pwd];
            }
        }
        return $result;
    }

    private static function process($did, $clientId, $originData)
    {
        $_SESSION[SessionKeys::LAST_ACTIVE_TIME] = self::$activeTime;
        $jsonDecode = json_decode($originData, JSON_OBJECT_AS_ARRAY);
        // 根据did 这里替换成具体设备的process类
        $action = DeviceFactory::createProcessAction($did);
        if($action != null) {
            DebugHelper::debug('[device process action]=' . get_class($action), $_SESSION);
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
     * 当客户端断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        $session = $_SESSION;
        if (is_array($session) && array_key_exists(SessionKeys::DID, $session)) {
            $did = $session[SessionKeys::DID];
        }
        DebugHelper::debug('[close]'.$did, $_SESSION);
        if(empty($did)){
            $result = (new  DeviceTcpClientDal())->getInfoByClientId($client_id);
            if(is_array($result) && array_key_exists(SessionKeys::DID, $result)) {
                $did = $result[SessionKeys::DID];
            }
        }
        if (!empty($did)) {
            DeviceFactory::getDeviceDal($did)->logoutByClientId($client_id);
//            (new  DeviceTcpClientDal())->updateByDid($did, ['tcp_client_id'=>'']);
            DebugHelper::debug('[close] clear db tcp_client_id'.$client_id, $_SESSION);
        }
        Gateway::closeClient($client_id);
    }

}