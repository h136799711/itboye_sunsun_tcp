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
use sunsun\server\consts\SessionKeys;
use sunsun\server\consts\SunsunDeviceConstant;
use sunsun\transfer_station\client\FactoryClient;
use sunsun\transfer_station\client\TransferClient;
use Workerman\Lib\Timer;
use Workerman\Worker;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class TimerEvents
{

    public static function onWorkerStart(Worker $businessWorker)
    {
        self::checkOfflineSession();
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
                $last_active_time = 0;
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
                    if ($cnt > 0 && $now - $last_active_time >= SunsunDeviceConstant::DEVICE_INFO_TIMER_INTERVAL) {
                        FactoryClient::getInfo($client_id, $did, $pwd);
                    }


                    if (array_key_exists('app_cnt', $session)) {
                        $currentCnt = $session['app_cnt'];
                        if ($cnt != $currentCnt) {
                            // 2. 更新会话信息
                            Gateway::updateSession($client_id, ['app_cnt' => $cnt]);
                        }
                    }

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
        Gateway::closeClient($client_id);
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     */
    public static function onMessage($client_id, $message)
    {
        return;
    }

    /**
     * 当客户端断开连接时触发
     * @param int $client_id 连接id
     * @throws \Exception
     */
    public static function onClose($client_id)
    {

    }
}