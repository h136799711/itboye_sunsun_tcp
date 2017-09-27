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
if(!defined('SUNSUN_ENV')){
    define("SUNSUN_ENV", "production");//debug|production 模式
}
define("CommonPassword", "1234bcda");//

use GatewayWorker\Lib\Gateway;
use sunsun\consts\LogType;
use sunsun\dal\DeviceTcpClientDal;
use sunsun\decoder\SunsunTDS;
use sunsun\helper\LogHelper;
use sunsun\model\DeviceTcpClientModel;
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
    //tcp通道无数据传输的最大时间
    public static $inactiveTimeInterval = 600;
    //接收到数据的最近一次时间
    private static $activeTime;
    private static $port;
    public static $db;//

    public static function onWorkerStart($businessWorker)
    {
        self::$dbPool = DbPool::getInstance();
        self::$port = $businessWorker->port;
        //记录Worker启动信息
        LogHelper::log(self::getDb(), $businessWorker->id, 'listen on '.self::$port, 'server_worker');
        self::loopDeviceInfo();
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
        try {

            self::$activeTime = time();
            if(empty($message)){
                self::log($client_id, 'message is empty', []);
                return;
            }
            //非字符串消息
            if (!is_string($message)) {
                self::jsonError($client_id, 'invalid message format', []);
                return;
            }

            // 0. 记录日志信息
            self::log($client_id, $message);

            $pwd = "";
            if (self::isLoginRequest()) {
                self::log($client_id, "login start");
                //第一次请求
                $pwd = CommonPassword;
                $result = self::login($client_id, $message, $pwd);

                self::log($client_id, "login complete");
            } else {
                self::log($client_id, "other process");
                //其它请求
                // 1. 获取密钥
                $result = self::getEncryptPwd($client_id);
                if ($result === false) {
                    self::jsonError($client_id, "get encrypt password failed", null);
                    return;
                }
                $pwd = $result['pwd'];
                $did = $result['did'];
                $result = SunsunTDS::decode($message, $pwd);
                if (empty($result)) {
                    self::jsonError($client_id, 'fail decode the data ', []);
                    return;
                }
                if (!$result->isValid()) {
                    self::jsonError($client_id, 'the data format is invalid', []);
                    return;
                }
                self::log($client_id, $result->getTdsOriginData(), "decode_message");
                // 3. 处理业务逻辑
                $result = self::process($did, $client_id, $result->getTdsOriginData());

            }

            if (empty($result)) {
                return;
            }

            if ($result instanceof \Exception) {
                self::closeChannel($client_id, $result->getTraceAsString());
                return;
            }

            self::log($client_id, json_encode($result), "return");
            if (method_exists($result, "toDataArray")) {
                // 4. 加密数据
                $encodeData = SunsunTDS::encode($result->toDataArray(), $pwd);
                self::jsonSuc($client_id, serialize($result), $encodeData);

            } else {
                self::jsonError($client_id, 'fail', []);
            }


        } catch (\Exception $ex) {
            self::log($client_id, $ex->getTraceAsString(), "exception");
            self::jsonError($client_id, $ex->getMessage(), []);
        }
        return;
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        // 删除定时器
        $session = $_SESSION;
        if(is_array($session) && array_key_exists('timer_id', $session)){
            $timer_id = $session['timer_id'];
            Timer::del($timer_id);
        }

        if(is_array($session) && array_key_exists('did', $session)){
            $did = $session['did'];
        }
        if(empty($did)){
            $result = (new  DeviceTcpClientDal())->getInfoByClientId($client_id);
            if(is_array($result) && array_key_exists('did', $result)) {
                $did = $result['did'];
            }
        }
        if(!empty($did)) {
            DeviceFactory::getDeviceDal($did)->logoutByClientId($client_id);
        }
    }

    //============================帮助方法

    private static function loopDeviceInfo(){

        Timer::add(3, function()
        {
            try{
            $allSessions = Gateway::getAllClientSessions();
            foreach ($allSessions as $client_id=>$session) {

                if (!empty($session) && is_array($session) && array_key_exists('did', $session)) {
                    if (array_key_exists('last_get_info', $session)) {
                        $lastGetInfoTime = $session['last_get_info'];
                        if (microtime(true) - $lastGetInfoTime <= 1) {
                            continue;
                        }
                    }
                    $pwd = '';
                    if (array_key_exists('pwd', $session)) {
                        $pwd = $session['pwd'];
                    }
                    $did = $session['did'];
//                    $data = 'pwd=' . $pwd . ' did=' . $did;
//                    TransferClient::sendMessageToGroup($did, $data, 666666);
                    $cnt = TransferClient::totalClientByGroup($did);
//                    TransferClient::sendMessageToGroup('S03C0000000106', $did.'timer'.$cnt, 33333);
                    if ($cnt > 0) {
//                        $data .= ' cnt=' . $cnt;
//                        TransferClient::sendMessageToGroup($did, 'xxxxxx', 11111);
//                        TransferClient::sendMessageToGroup($did, $data, 666666);
                        // 1. 仅当链接数大于0时，才向设备请求获取设备信息
                        FactoryClient::getInfo($client_id, $did, $pwd);
                    }

                    // 2. 更新会话信息，用于调试查看，可以去掉这一句
                    Gateway::updateSession($client_id, ['last_get_info' => microtime(true),'app_cnt' => $cnt]);
                }
            }
            }catch (\Exception $ex){
                TransferClient::sendMessageToGroup('S03C0000000106', $ex->getMessage(), -777);
            }
        });
    }

    private static function process($did, $clientId, $originData)
    {
        //处理请求
        self::log($did, $originData, 'process');
        $jsonDecode = json_decode($originData, JSON_OBJECT_AS_ARRAY);
        //1. Device 这里替换成具体设备的process类
        $action = DeviceFactory::createProcessAction($did);
        $resp = $action->process($did,$clientId,$jsonDecode);
        return $resp;
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
        if(array_key_exists('did', $session)){
            $did = $session['did'];
            $result = DeviceFactory::getDeviceDal($did) ->loginByTcpClientId($client_id, self::getClientIp());
        }
        return $result;
    }

    /**
     * 获取数据库链接
     * @param $client_id
     * @return \sunsun\server\db\DbPool
     */
    public static function getDb($client_id=''){
        if(!empty($client_id)){
            $session = Gateway::getSession($client_id);
            if(array_key_exists('did',$session)){
                $did = $session['did'];
                return self::$dbPool->getDb($did);
            }
        }
        return self::$dbPool->getGlobalDb();
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

        $result = SunsunTDS::decode($message, $pwd);
        if ($result == null) {
            self::jsonError($client_id, 'decode fail', []);
            return false;
        }
        if (!$result->isValid()) {
            self::jsonError($client_id, 'the data format is invalid'.$message, []);
            return false;
        }
        //{"reqType": "1","sn": "0","did": "10000001","ver": "V1.0","pwd": "gigw+DAcMITN4SuEe6JmkA=="}
        $originData = $result->getTdsOriginData();

        $data = json_decode($originData, JSON_OBJECT_AS_ARRAY);
        if(!array_key_exists('did',$data)){
            self::jsonError($client_id, 'the did is need', []);
            return false;
        }
        //2. Device 这里替换成具体设备的请求工厂类
        $did = $data['did'];
        // 设置did
        $_SESSION['did'] = $did;
        $req =  DeviceFactory::createLoginReq($did,$data);
        if (empty($did)) {
            return false;
        }
        $dal = DeviceFactory::getDeviceDal($did);
        $result = $dal->getInfoByDid($did);
        if (empty($result)) {
            self::jsonError($client_id, 'which did=' . $did . 'is not exists', []);
            return false;
        }

        $id = $result['id'];
        $pwd = $result['pwd'];
        $_SESSION['pwd'] = $pwd;
        $hb = $result['hb'];//心跳周期（单位：秒）
        $originPwd = SunsunTDS::isLegalPwd($data['pwd'], $pwd);
        if (empty($originPwd)) {
            self::jsonError($client_id, $data['pwd'].'the control password decode fail,key='.$pwd, []);
            return false;
        }

        $data['origin_pwd'] = $originPwd;
        //更新控制密码
        $ver = $req->getVer();
        $entity = [
            'ver'=>$ver,
            'ctrl_pwd' => $originPwd,
            'last_login_time' => self::$activeTime,
            'update_time' => self::$activeTime,
            'last_login_ip' => self::getClientIp(),
            'tcp_client_id' => $client_id,
            'offline_notify'=>1,
        ];
        if(method_exists($req,'getType')){
            $type = $req->getType();
            $entity['device_type'] = $type;
        }
        $dal->update($id, $entity);
        $_SESSION['is_first'] = 1;
        self::loginSuccess($client_id,$did);
        //设置返回响应包
        //3. Device 这里替换成具体设备的登录响应类
        $resp = DeviceFactory::createLoginResp($did);
        $resp->setSn($req->getSn());
        $resp->setLoginSuccess();
        $resp->setHb($hb);
        //绑定did 和 client_id
        Gateway::bindUid($client_id, $did);
        $group = substr($did,0 ,3);
        Gateway::joinGroup($client_id,$group);
        return $resp;
    }

    /**
     * 登录成功后进行操作
     * @param $client_id
     * @param $did
     */
    private static function loginSuccess($client_id,$did){
        $dal = new DeviceTcpClientDal(DbPool::getInstance()->getGlobalDb());
        $result = $dal->getInfoByDid($did);
        if (empty($result)) {
            // insert
            $po = new  DeviceTcpClientModel();
            $po->setDid($did);
            $po->setTcpClientId($client_id);
            $po->setPrevLoginTime(time());
            $dal->insert($po);
        }else{
            // update
            $dal->updateByDid($did,['tcp_client_id'=>$client_id,'prev_login_time'=>time()]);
        }
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
     * 关闭
     * @param $client_id
     * @param $closeMsg
     */
    private static function closeChannel($client_id, $closeMsg)
    {
        //3. tcp通道关闭
        Gateway::closeClient($client_id);
    }

    /**
     * 日志记录
     * @param string $client_id 通道编号
     * @param string $message 日志内容
     * @param string $type 日志类型
     */
    public static function log($client_id, $message, $type = 'common')
    {
        LogHelper::log(self::getDb($client_id), $client_id, $message, 'server_' . $type);
    }

    /**
     * 返回错误信息
     * @param $client_id
     * @param $msg
     * @param $data
     */
    private static function jsonError($client_id, $msg, $data)
    {
        self::log($client_id, $msg, LogType::Error);
        self::closeChannel($client_id, $msg);
    }

    /**
     * 返回正确信息
     * @param $client_id
     * @param $msg
     * @param $data
     */
    private static function jsonSuc($client_id, $msg, $data)
    {
        // 只记录成功的时间
        $_SESSION['last_active_time'] = self::$activeTime;
        self::log($client_id, $msg . ',' . serialize($data), LogType::Success);
        Gateway::sendToClient($client_id, $data);
    }

    /**
     * 该次请求是否作为登录请求处理
     * @return bool
     */
    protected static function isLoginRequest(){
        if(!array_key_exists('is_first', $_SESSION)){
            $_SESSION['is_first'] = 0;
        }
        return $_SESSION['is_first'] == 0;
    }

}