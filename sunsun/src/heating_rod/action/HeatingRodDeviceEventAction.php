<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\heating_rod\action;


use sunsun\heating_rod\dal\HeatingRodDeviceEventDal;
use sunsun\heating_rod\model\HeatingRodDeviceEventModel;
use sunsun\heating_rod\req\HeatingRodDeviceEventReq;
use sunsun\heating_rod\resp\HeatingRodDeviceEventResp;

/**
 * Class HeatingRodDeviceEventAction
 * 设备事件记录
 * @package sunsun\heating_rod\action
 */
class HeatingRodDeviceEventAction
{
    public function logEvent($did, $client_id, HeatingRodDeviceEventReq $req)
    {
        $eventType = $req->getCode();
        $eventInfo = json_encode(['t' => $req->getT()]);
        $now = time();
        $dal = (new HeatingRodDeviceEventDal());
        $do = new HeatingRodDeviceEventModel();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $result = $dal->insert($do);
        $resp = new HeatingRodDeviceEventResp($req);
        $resp->setState(0);
        return $resp;
    }

}