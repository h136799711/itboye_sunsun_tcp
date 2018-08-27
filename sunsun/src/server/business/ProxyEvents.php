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
use sunsun\helper\LimitHelper;
use Workerman\Worker;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class ProxyEvents
{
    /**
     * @var LimitHelper
     */
    static $connectLimitGate = null;
    /**
     * @var LimitHelper
     */
    static $msgLimitGate = null;

    public static function onWorkerStart(Worker $businessWorker)
    {
        self::$connectLimitGate = new LimitHelper(30);
        self::$msgLimitGate = new LimitHelper(500, 5);
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
        if (self::$connectLimitGate->ifOverLimit()) {
            Gateway::sendToClient($client_id, 'please connect after 30s');
            Gateway::closeClient($client_id);
        }
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     * @throws \Exception
     */
    public static function onMessage($client_id, $message)
    {
        if (self::$msgLimitGate->ifOverLimit()) {
            Gateway::sendToClient($client_id, 'fail_fail_fail_fail');
        } else {
            Gateway::sendToClient($client_id, 'success_success_success_success');
        }
    }
}