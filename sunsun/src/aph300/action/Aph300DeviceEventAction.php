<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aph300\action;


use sunsun\aph300\dal\Aph300DeviceEventDal;
use sunsun\aph300\model\Aph300DeviceEventModel;
use sunsun\aph300\req\Aph300DeviceEventReq;
use sunsun\aph300\resp\Aph300DeviceEventResp;

/**
 * Class Aph300DeviceEventAction
 * 设备事件记录
 * @package sunsun\aph300\action
 */
class Aph300DeviceEventAction
{
    public function logEvent($did, $client_id, Aph300DeviceEventReq $req)
    {
        $eventType = $req->getCode();
        $eventInfo = json_encode(['t' => $req->getT(), 'ph' => $req->getPh(), 'code_desc' => $req->getCodeDesc()]);
        $now = time();
        $dal = (new Aph300DeviceEventDal());
        $do = new Aph300DeviceEventModel();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $result = $dal->insert($do);
        $resp = new Aph300DeviceEventResp($req);
        $resp->setState(0);
        return $resp;
    }

}