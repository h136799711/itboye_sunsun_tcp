<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aq806\action;


use sunsun\aq806\dal\Aq806DeviceEventDal;
use sunsun\aq806\model\Aq806DeviceEventModel;
use sunsun\aq806\req\Aq806DeviceEventReq;
use sunsun\aq806\resp\Aq806DeviceEventResp;

/**
 * Class Aq806DeviceEventAction
 * 设备事件记录
 * @package sunsun\aq806\action
 */
class Aq806DeviceEventAction
{
    public function logEvent($did, $client_id, Aq806DeviceEventReq $req)
    {
        $eventType = $req->getCode();
        $eventInfo = json_encode(['dyn' => $req->getDyn(), 't' => $req->getT(), 'ph' => $req->getPh()]);
        $now = time();
        $dal = (new Aq806DeviceEventDal());
        $do = new Aq806DeviceEventModel();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $result = $dal->insert($do);
        $resp = new Aq806DeviceEventResp($req);
        $resp->setState(0);
        return $resp;
    }

}