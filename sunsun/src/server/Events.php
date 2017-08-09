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
define("SUNSUN_WORKER_HOST", "101.37.37.167");
define("SUNSUN_WORKER_PORT", "3306");
define("SUNSUN_WORKER_USER", "sunsun");
define("SUNSUN_WORKER_PASSWORD", "poiuyTREWQ123456");
define("SUNSUN_WORKER_DB_NAME", "sunsun_xiaoli");

use GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{

    //tcp通道无数据传输的最大时间
    public static $inactiveTimeInterval = 600;

    public static $tcpClientDal;

    public static $clientDal;

    public static function onWorkerStart($businessWorker)
    {
        $time_interval = 30;
        \Workerman\Lib\Timer::add($time_interval, function () {
            $allSessions = Gateway::getAllClientSessions();
            $nowTime = time();
            foreach ($allSessions as $clientId => $session) {
                $lastActiveTime = $session['last_active_time'];
                if ($nowTime - $lastActiveTime > self::$inactiveTimeInterval) {
                    $msg = "adt tcp server waiting for more than " . self::$inactiveTimeInterval . " seconds";
                    self::closeChannel($clientId, $msg);
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
        $count = \GatewayClient\Gateway::getAllClientCount();
        echo 'linking tcp client = '.$count;
        self::jsonSuc($client_id, 'success' , 'count='.$count);
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
