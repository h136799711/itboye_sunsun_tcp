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

use by\component_3rdQueueClient\AmqpRabbitClient;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Lib\Gateway;
use sunsun\decoder\SunsunTDS;
use sunsun\helper\LimitHelper;
use sunsun\helper\LogHelper;
use sunsun\server\consts\SessionKeys;
use sunsun\server\db\DbPool;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\server\resp\BaseControlDeviceClientResp;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;
use sunsun\server\resp\BaseDeviceInfoClientResp;
use sunsun\server\resp\BaseDeviceLoginServerResp;
use sunsun\server\tcpChannelCommand\CommandFactory;
use Symfony\Component\Dotenv\Dotenv;
use Workerman\Lib\Timer;
use Workerman\Worker;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class ProxyEvents
{
    /**
     * @var  \sunsun\server\db\DbPool
     */
    public static $dbPool;
    private static $activeTime;

    /**
     * @var LimitHelper
     */
    public static $connectLimitGate;

    /**
     * @var LimitHelper
     */
    public static $msgLimitGate;

    /**
     * @var AmqpRabbitClient
     */
    public static $eventClient;

    public static $regAddr;
    public static $cacheMsg;
    public static $workerName;
    public static $workerId;


    public static function onWorkerStart(BusinessWorker $businessWorker)
    {
        self::$regAddr = $businessWorker->registerAddress;
        if (is_array(self::$regAddr)) {
            self::$regAddr = self::$regAddr[0];
        }
        self::$workerName = $businessWorker->name;
        self::$workerId = $businessWorker->id;
        $rootPath = dirname(dirname(dirname(dirname(__DIR__)))).'/.env';
        (new Dotenv())->load($rootPath);
        self::$connectLimitGate = new LimitHelper(500, 5);
        self::$msgLimitGate = new LimitHelper(600, 3);
        self::$dbPool = DbPool::getInstance();
        self::$cacheMsg = [];
        self::initAmqp();
    }

    public static function initAmqp() {
        $host = getenv('AMQP_HOST');
        $user = getenv('AMQP_USER');
        $pass = getenv('AMQP_PASS');
        $vhost = getenv('AMQP_VHOST');
        $port = getenv("AMQP_PORT");
        // 这边是在启动的时候不用管
        self::$eventClient = new AmqpRabbitClient($host, $port, $user, $pass, $vhost);
        self::$eventClient->openConnection();
        self::$eventClient->bindQueueAndExchange(self::$workerName, self::$workerName);

        // 一秒 100
        Timer::add(1, function() {
            // 增加异常捕获，防止 amqp服务器出错影响链接通道
            try {
                $cnt = 400;
                while($cnt-- && count(self::$cacheMsg) > 0) {
                    $vo = array_shift(self::$cacheMsg);
                    self::$eventClient->publish($vo[0], json_encode($vo[1]));
                    usleep(10000);
                }
            } catch (\Exception $exception) {
                Worker::log($exception->getTraceAsString());
            }
        });
    }

    public static function publish($content) {
        if (is_array(self::$cacheMsg) && count(self::$cacheMsg) < 50000) {
            array_push(self::$cacheMsg, [self::$workerName, $content]);
        }
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     * @throws \Exception
     */
    public static function onConnect($client_id)
    {
        // 限制高并发链接
//        if (self::$connectLimitGate->ifOverLimit()) {
//            self::closeChannel($client_id, 'over limit');
//        }
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

    /**
     * 当客户端发来消息时触发
     * 注意:
     *    谨慎发送信息给设备，如果设备处理不了信息,设备会断开重连
     * @param int $client_id 连接id
     * @param $message
     * @return bool|void
     * @throws \Exception
     */
    public static function onMessage($client_id, $message)
    {
        if (is_array($_SESSION) && array_key_exists('close', $_SESSION) && $_SESSION['close'] == 1) {
            self::closeChannel($client_id, 'this need close socket');
            return ;
        }

        if (empty($message) || !is_string($message) || $message == 'A') {
            self::closeChannel($client_id);
            return;
        }

        self::$activeTime = time();
        $_SESSION[SessionKeys::LAST_ACTIVE_TIME] = self::$activeTime;
        self::acceptCommand($client_id);
        $msgChannel = 0;
        $did = '';
        if (self::isLoginRequest()) {
            // 限制登录消息
//            if (self::$msgLimitGate->ifOverLimit()) {
//                Gateway::closeClient($client_id);
//                return ;
//            }
            $msgChannel = 1;
            //第一次请求
            $pwd = Password::getSecretKey(Password::TYPE_LOGIN, $client_id);
            $result = self::login($client_id, $message, $pwd);
            if (!($result instanceof BaseDeviceLoginServerResp)) {
                self::jsonError($client_id, 'msg_channel_'.$msgChannel.'fail'.json_encode($result), []);
                return;
            }
            if (is_array($_SESSION) && array_key_exists(SessionKeys::PWD, $_SESSION)) {
                $pwd = $_SESSION[SessionKeys::PWD];
            }
        } else {
            $msgChannel = 2;
            // 1. 获取密钥
            $result = Password::getSecretKey(Password::TYPE_OTHER, $client_id);
            if (empty($result)) {
                self::jsonError($client_id, "get encrypt password failed", null);
                return;
            }
            $pwd = $result[SessionKeys::PWD];
            $did = $result[SessionKeys::DID];
            $result = SunsunTDS::decode($message, $pwd);
            if (empty($result)) {
//                self::jsonError($client_id, 'fail decode the data ', []);
                return;
            }

            if (!$result->isValid()) {
//                self::jsonError($client_id, 'the data format is invalid' . json_encode($result->getTdsOriginData(),
//                        JSON_OBJECT_AS_ARRAY), []);
                return;
            }
            $decodeData = $result->getTdsOriginData();
            // 3. 处理业务逻辑
            $result = self::process($did, $client_id, $decodeData);

//            if (empty($result)) {
//                self::jsonError($client_id, "process result is empty".$decodeData, null);
//                return ;
//            }

            if ($result instanceof BaseDeviceInfoClientResp
               || $result instanceof BaseDeviceFirmwareUpdateClientResp
               || $result instanceof  BaseControlDeviceClientResp) {
                // 设备响应的信息 不回复信息
                // 只响应设备请求的信息
                return ;
            }

        }

        if (method_exists($result, "toDataArray")) {
            $data = $result->toDataArray();
            $newData = [];
            foreach ($data as $key=>$val) {
                if (!is_null($val)) {
                    $newData[$key] = $val;
                }
            }
            // 4. 加密数据
            $encodeData = SunsunTDS::encode($newData, $pwd);
            Gateway::sendToClient($client_id, $encodeData);
        }
//        else {
//            self::jsonError($client_id, 'msg_channel_'.$msgChannel.'fail'.json_encode($result), []);
//        }
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
     * @throws \Exception
     */
    private static function login($client_id, $message, $pwd)
    {
        $result = SunsunTDS::decode($message, $pwd);

        if ($result == null) {
            self::jsonError($client_id, $pwd.'decode fail'.serialize($message), []);
            return null;
        }
        if (!$result->isValid()) {
            self::jsonError($client_id, ' the data format is invalid' . $message, []);
            return null;
        }
        //{"reqType": "1","sn": "0","did": "10000001","ver": "V1.0","pwd": "gigw+DAcMITN4SuEe6JmkA=="}
        $originData = $result->getTdsOriginData();

        $data = json_decode($originData, JSON_OBJECT_AS_ARRAY);
        if (empty($data) || !array_key_exists('did', $data) || empty($data[SessionKeys::DID])) {
            self::jsonError($client_id, serialize($originData) . 'the did is need', []);
            return null;
        }
        //2. Device 这里替换成具体设备的请求工厂类
        $did = $data[SessionKeys::DID];
        $req = DeviceFacadeFactory::createLoginReq($did, $data);
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        if ($dal == null) {
            self::jsonError($client_id, 'did invalid' . $did . 'is not exists. origin_data ' . $originData, []);
            return null;
        }
        // 1. 增加过滤\u0003
        $did = str_replace("\u0003", "", $did);
        $did = str_replace("\\u0003", "", $did);
        $result = $dal->getInfoByDid($did);
        if (empty($result)) {
            self::jsonError($client_id, 'which did=' . $did . 'is not exists. origin_data ' . $originData, []);
            return null;
        }

        $id = $result['id'];
        $pwd = $result[SessionKeys::PWD];
        $hb = $result['hb'];//心跳周期（单位：秒）

        // 设置did,pwd
        $_SESSION[SessionKeys::DID] = $did;
        // 存在session中 就不需要再到数据库查询一次了
        $_SESSION[SessionKeys::PWD] = $pwd;
        $originPwd = SunsunTDS::isLegalPwd($data[SessionKeys::PWD], $pwd);
        if (empty($originPwd)) {
            self::jsonError($client_id, $data[SessionKeys::PWD] . 'the control password decode fail,key=' . $pwd . ' and origin_data ' . $originData, []);
            return null;
        }

        //更新控制密码
        $data['origin_pwd'] = $originPwd;
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
        if (method_exists($req, 'getType') && strlen($req->getType()) > 0) {
            $type = $req->getType();
            $entity['device_type'] = $type;
        }
        $dal->update($id, $entity);
        self::loginSuccess($client_id, $did);

        //设置返回响应包
        //3. Device 这里替换成具体设备的登录响应类
        $resp = DeviceFacadeFactory::createLoginResp($did);
        $resp->setServerInfo($result);
        $resp->setSn($req->getSn());
        $resp->setLoginSuccess();
        $resp->setHb($hb);
        //绑定did 和 client_id
        Gateway::bindUid($client_id, $did);
        self::publish(['type'=>'login', 't'=>time(), 'did'=>$did, 'client_id'=>$client_id, 'reg_addr'=>
            self::$regAddr]);
        return $resp;
    }

    /**
     * 返回错误信息
     * @param $client_id
     * @param $msg
     * @param $data
     * @throws \Exception
     */
    private static function jsonError($client_id, $msg, $data = [])
    {
        $session = Gateway::getSession($client_id);
        if (!empty($msg)) {
            if (!empty($session)) {
                $msg = 'session:' . json_encode($session) . ',msg:' . json_encode($msg);
            }
            $remoteIp = self::getClientIp();
            $remotePort = self::getRemotePort();
            $gatewayPort = self::getGatewayPort();
            $gatewayIp = self::getGatewayIp();
            LogHelper::log(self::getDb(''), $client_id, $msg, 'error', $remoteIp, $remotePort, $gatewayIp, $gatewayPort);
        }

        self::closeChannel($client_id, $msg);
    }

    /**
     * 关闭
     * @param $client_id
     * @param $closeMsg
     * @throws \Exception
     */
    private static function closeChannel($client_id, $closeMsg = '')
    {

        $_SESSION['close'] = 1;
        Gateway::sendToClient($client_id, 'close your socket');
//        Gateway::closeClient($client_id);
    }

    private static function getRemotePort()
    {
        if ($_SERVER && array_key_exists("REMOTE_PORT", $_SERVER)) {
            return $_SERVER['REMOTE_PORT'];
        }
        return "";
    }

    /**
     * 获取当前网关监听的端口
     * @return string
     */
    private static function getGatewayPort()
    {
        if ($_SERVER && array_key_exists("GATEWAY_PORT", $_SERVER)) {
            return $_SERVER['GATEWAY_PORT'];
        }
        return "";
    }

    /**
     * 获取当前网关ip
     * @return string
     */
    private static function getGatewayIp()
    {
        if ($_SERVER && array_key_exists("GATEWAY_ADDR", $_SERVER)) {
            return $_SERVER['GATEWAY_ADDR'];
        }
        return "";
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
    }

    /**
     * @param $did
     * @param $clientId
     * @param $originData
     * @return null|\sunsun\po\BaseRespPo
     * @throws \Exception
     */
    private static function process($did, $clientId, $originData)
    {
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
     * @throws \Exception
     */
    public static function onClose($client_id)
    {
        if (is_array($_SESSION) && array_key_exists(SessionKeys::DID, $_SESSION)) {
            $did = $_SESSION[SessionKeys::DID];
            self::publish(['type'=>'logout', 't'=>time(),'did'=>$did, 'client_id'=>$client_id]);
        }
    }

}