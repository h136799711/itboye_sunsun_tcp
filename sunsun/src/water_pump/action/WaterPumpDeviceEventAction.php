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
use sunsun\server\model\BaseDeviceEventModel;
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
     * 最近几个相同的数据只会插一次
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
        $flag = false;
        foreach ($event as $row) {
            if ($row['event_type'] != $eventType
                || $row['event_info'] != $eventInfo
                || $now - intval($row['create_time']) > 600) {
                $flag = true;
                break;
            }
        }

        if (count($event) == 0 || $flag) {

            // event_type 不相等
            // event_info 不相等
            // 时间超过 600秒以上
            // 以上任一条件满足
            $this->insertDeviceEvent($data, $did);
            // 保持个数限制
            if (count($event) >= self::MAX_DELAY_COUNT) {
                // 从开头移走一个
                array_shift($event);
            }

            array_push($event, $data);

            Gateway::updateSession($client_id, ['event' => $event]);
        }
    }

    private function insertDeviceEvent($data, $did)
    {
        $dal = DeviceFacadeFactory::getDeviceEventDal($did);
        $do = new BaseDeviceEventModel();
        $now = time();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($data['event_info']);
        $do->setEventType($data['event_type']);
        $dal->insert($do);
    }

}