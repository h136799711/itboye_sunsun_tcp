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
use Workerman\Worker;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class ProxyEvents
{


    static $limitTimeSeconds = 3;

    // 30秒内不能超过600次链接 否则都主动关闭链接
    static $limitCnt = 100;
    static $reqCnt = [];

    public static function onWorkerStart(Worker $businessWorker)
    {

    }

    public static function getReqCnt() {
        $now = time();
        $cnt = 0;
        for ($i = 0; $i < count(self::$reqCnt); $i++) {
            if (self::$reqCnt[$i][0] > $now - self::$limitTimeSeconds) {
                $cnt += self::$reqCnt[$i][1];
            }
        }
        return $cnt;
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        // 限制高并发链接
        if (self::ifOverLimitTimes()) {
            Gateway::sendToClient($client_id, 'please connect after 30s');
            Gateway::closeClient($client_id);
        }
    }

    public static function ifOverLimitTimes()
    {
        $now = time();
        $limit = 0;
        // 大于该索引的都要去除
        $expiredTimeIndex = -1;
        for ($i = 0; $i < count(self::$reqCnt); $i++) {
            $passedTime = &self::$reqCnt[$i];
            if ($passedTime[0] <= $now - self::$limitTimeSeconds) {
                $expiredTimeIndex = $i;
            } else {
                $limit += $passedTime[1];
            }
        }
        self::$reqCnt = array_reverse(self::$reqCnt);
        while ($expiredTimeIndex-- > 0) {
            array_pop(self::$reqCnt);
        }
        self::$reqCnt = array_reverse(self::$reqCnt);

        if ($limit >= self::$limitCnt) {
            return true;
        }

        if (count(self::$reqCnt) > 0 && self::$reqCnt[count(self::$reqCnt) - 1][0] == $now) {
            self::$reqCnt[count(self::$reqCnt) - 1][1]++;
        } else {
            array_push(self::$reqCnt, [$now, 1]);
        }
        return false;
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     * @throws \Exception
     */
    public static function onMessage($client_id, $message)
    {
        if (empty($message) || !is_string($message)) {
            return;
        }

        if ($message == 'A') {
            return;
        }

        Gateway::sendToClient($client_id, $message);
    }
}