<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aph300\action;


use sunsun\server\business\ProxyEvents;
use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\interfaces\BaseAction;
use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class Aph300DeviceEventAction
 * 设备事件记录
 * @package sunsun\aph300\action
 */
class Aph300DeviceEventAction extends BaseAction
{
    public function deviceEventLog($did, $client_id, BaseDeviceEventClientReq $req)
    {
        $resp = RespFacadeFactory::createDeviceEventRespObj($did, $req);
        $resp->setState(0);

        $eventType = $req->getCode();

        $eventInfo = $req->getEventInfo();
        unset($eventInfo['sn']);//必须除去sn
        $eventInfo = json_encode($eventInfo);
        $now = time();
        $data = [
            'did' => $did,
            "event_type" => $eventType,
            "event_info" => $eventInfo,
            "create_time" => $now,
            'type'=>'event',
        ];
        ProxyEvents::publish($data);
        return $resp;
    }
}