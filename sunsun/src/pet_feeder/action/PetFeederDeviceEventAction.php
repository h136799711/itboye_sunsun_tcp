<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\pet_feeder\action;


use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\interfaces\BaseActionV2;
use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * ClassPetFeederDeviceEventAction
 * 设备事件记录
 * @package sunsun\pet_feeder\action
 */
class PetFeederDeviceEventAction extends BaseActionV2
{

    /**
     * 通用设备推送事件记录
     * @param $did
     * @param $client_id
     * @param BaseDeviceEventClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\adt\resp\AdtHbResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\aq806\resp\Aq806HbResp|\sunsun\filter_vat\resp\FilterVatCtrlDeviceResp|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|\sunsun\filter_vat\resp\FilterVatDeviceInfoResp|\sunsun\filter_vat\resp\FilterVatDeviceUpdateResp|\sunsun\filter_vat\resp\FilterVatHbResp|\sunsun\filter_vat\resp\FilterVatLoginResp|\sunsun\water_pump\resp\WaterPumpCtrlDeviceResp|\sunsun\water_pump\resp\WaterPumpDeviceInfoResp|\sunsun\water_pump\resp\WaterPumpDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpHbResp
     */
    public function deviceEventLog($did, $client_id, BaseDeviceEventClientReq $req)
    {
        echo $did, " 设备事件 ".json_encode($req->toDataArray()), "\n";

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
        $this->publish($data);
        return $resp;
    }

}