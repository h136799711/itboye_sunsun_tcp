<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\adt\action;


use sunsun\adt\dal\AdtDeviceEventDal;
use sunsun\adt\model\AdtDeviceEventModel;
use sunsun\adt\req\AdtDeviceEventReq;
use sunsun\adt\resp\AdtDeviceEventResp;

/**
 * Class AdtDeviceEventAction
 * 设备事件记录
 * @package sunsun\adt\action
 */
class AdtDeviceEventAction
{
    public function logEvent($did, $client_id, AdtDeviceEventReq $req)
    {
        $eventType = $req->getCode();
        $eventInfo = json_encode(['dyn' => $req->getDyn(), 't' => $req->getT(), 'ph' => $req->getPh()]);
        $now = time();
        $dal = (new AdtDeviceEventDal());
        $do = new AdtDeviceEventModel();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $result = $dal->insert($do);
        $resp = new AdtDeviceEventResp($req);
        $resp->setState(0);
        return $resp;
    }

}