<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
#declare(ticks=1);

date_default_timezone_set("Etc/GMT");

define("SUNSUN_ENV", "production");//debug|production 模式

use GatewayWorker\Lib\Gateway;

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

    public static function onWorkerStart($businessWorker)
    {
        self::$dbPool = \sunsun\server\db\DbPool::getInstance();
        self::$port = $businessWorker->port;
        //记录Worker启动信息
        self::log($businessWorker->id,'listen on '.self::$port, 'worker');
    }

    /**
     * 日志记录
     * @param string $client_id 通道编号
     * @param string $message 日志内容
     * @param string $type 日志类型
     */
    public static function log($client_id, $message, $type = 'common')
    {
        \sunsun\helper\LogHelper::log(self::getDb($client_id), $client_id, $message, 'server_' . $type);
    }

    /**
     * 返回错误信息
     * @param $client_id
     * @param $msg
     * @param $data
     */
    private static function jsonError($client_id, $msg, $data)
    {
        self::log($client_id, $msg, \sunsun\consts\LogType::Error);
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
        self::log($client_id, $msg . ',' . serialize($data), \sunsun\consts\LogType::Success);
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
                Gateway::
                //第一次请求
                $pwd = \sunsun\server\device\DeviceFactory::getPublicPwd($this->);
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
                $result = \sunsun\decoder\SunsunTDS::decode($message, $pwd);
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
                $encodeData = \sunsun\decoder\SunsunTDS::encode($result->toDataArray(), $pwd);
                self::jsonSuc($client_id, serialize($result), $encodeData);

            } else {
                self::jsonError($client_id, 'fail', []);
            }


        } catch (Exception $ex) {
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
        self::closeChannel($client_id, "tcp client close the channel");
    }

    //============================帮助方法





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

    private static function jsonSuc($client_id, $msg, $data)
    {
        Gateway::sendToClient($client_id, $data);
    }


    /**
     * 关闭
     * @param $clientId
     * @param $closeMsg
     */
    private static function closeChannel($clientId, $closeMsg)
    {
        //3. tcp通道关闭
        Gateway::closeClient($clientId);
    }

}
