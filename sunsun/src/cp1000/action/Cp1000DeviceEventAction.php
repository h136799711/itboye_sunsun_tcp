<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;


use sunsun\cp1000\dal\Cp1000DeviceEventDal;
use sunsun\cp1000\model\Cp1000DeviceEventModel;
use sunsun\cp1000\req\Cp1000DeviceEventReq;
use sunsun\cp1000\resp\Cp1000DeviceEventResp;

/**
 * Class Cp1000DeviceEventAction
 * 设备事件记录
 * @package sunsun\cp1000\action
 */
class Cp1000DeviceEventAction
{
    public function logEvent($did, $client_id, Cp1000DeviceEventReq $req)
    {
        $dal = (new Cp1000DeviceEventDal());
        $do = new Cp1000DeviceEventModel();
        $eventInfo = json_encode([]);
        $eventType = $req->getCode();
        $now = time();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $result = $dal->insert($do);
        $resp = new Cp1000DeviceEventResp($req);
        $resp->setState(0);
        return $resp;
    }

}