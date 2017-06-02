<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\water_pump\action;


use sunsun\water_pump\dal\WaterPumpDeviceEventDal;
use sunsun\water_pump\model\WaterPumpDeviceEventModel;
use sunsun\water_pump\req\WaterPumpDeviceEventReq;
use sunsun\water_pump\resp\WaterPumpDeviceEventResp;

/**
 * Class WaterPumpDeviceEventAction
 * 设备事件记录
 * @package sunsun\water_pump\action
 */
class WaterPumpDeviceEventAction
{
    public function logEvent($did, $client_id, WaterPumpDeviceEventReq $req)
    {
        $eventType = $req->getCode();
        $eventInfo = json_encode(['t' => $req->getT(), 'ph' => $req->getPh()]);
        $now = time();
        $dal = (new WaterPumpDeviceEventDal());
        $do = new WaterPumpDeviceEventModel();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $result = $dal->insert($do);
        $resp = new WaterPumpDeviceEventResp($req);
        $resp->setState(0);
        return $resp;
    }

}