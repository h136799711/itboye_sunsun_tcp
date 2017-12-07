<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\water_pump\action;

use GatewayWorker\Lib\Gateway;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\interfaces\BaseAction;
use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class WaterPumpDeviceEventAction
 * 设备事件记录
 * @package sunsun\water_pump\action
 */
class WaterPumpDeviceEventAction extends BaseAction
{
    /**
     * 最大延迟事件数量
     */
    const MAX_DELAY_COUNT = 2;

    public function deviceEventLog($did, $client_id, BaseDeviceEventClientReq $req)
    {

        $this->delayInsertDeviceEvent($did, $client_id, $req);

        $resp = RespFacadeFactory::createDeviceEventRespObj($did, $req);
        $resp->setState(0);
        return $resp;
    }

    /**
     * 延迟插入
     * @param $did
     * @param $client_id
     * @param $req
     */
    private function delayInsertDeviceEvent($did, $client_id, BaseDeviceEventClientReq $req)
    {
        $session = Gateway::getSession($client_id);

        if (array_key_exists('event', $session)) {
            $event = $session['event'];
        } else {
            $event = [];
        }
        $currentEventCnt = count($event);

        $eventType = $req->getCode();
        $eventInfo = json_encode($req->getEventInfo());
        $now = time();
        $data = [
            'did' => $did,
            "event_type" => $eventType,
            "event_info" => $eventInfo,
            "create_time" => $now
        ];

        // 判断是否 可以插入数据
        if (count($event) > 0) {
            foreach ($event as $row) {
                if ($row['event_type'] != $eventType
                    || $row['event_info'] != $eventInfo
                    || $now - intval($row['create_time']) > 600) {
                    // event_type 不相等
                    // event_info 不相等
                    // 时间超过 600秒以上
                    // 以上任一条件满足
                    array_push($event, $data);
                    break;
                }
            }

            if (count($event) >= self::MAX_DELAY_COUNT) {
                $this->insertAll($event, $did);
                $event = [];//清空
            }

        } else {
            array_push($event, $data);
        }

        // 事件数量有所改变才更新
        if ($currentEventCnt != count($event)) {
            Gateway::updateSession($client_id, ['event' => $event]);
        }
    }

    private function insertAll($list, $did)
    {
        $dal = DeviceFacadeFactory::getDeviceEventDal($did);
        $cols = ["did", "event_type", "event_info", "create_time"];
        $dal->insertAll($list, $cols);
    }

}