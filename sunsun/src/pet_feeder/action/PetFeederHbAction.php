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
use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * ClassPetFeederHbAction
 * 心跳包处理
 * @package sunsun\pet_feeder\action
 */
class PetFeederHbAction extends BaseActionV2
{

    /**
     * 通用设备心跳请求
     * @param $did
     * @param $clientId
     * @param BaseHeartBeatClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\aph300\resp\Aph300CtrlDeviceResp|\sunsun\aph300\resp\Aph300DeviceInfoResp|\sunsun\aph300\resp\Aph300DeviceUpdateResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\cp1000\resp\Cp1000CtrlDeviceResp|\sunsun\cp1000\resp\Cp1000DeviceFirmwareUpdateResp|\sunsun\cp1000\resp\Cp1000DeviceInfoResp|\sunsun\cp1000\resp\Cp1000HbResp|\sunsun\heating_rod\resp\HeatingRodCtrlDeviceResp|\sunsun\heating_rod\resp\HeatingRodDeviceInfoResp|\sunsun\heating_rod\resp\HeatingRodDeviceUpdateResp
     */
    public function deviceHeartBeat($did, $clientId, BaseHeartBeatClientReq $req)
    {
        echo $did, " 设备心跳信息".json_encode($req->toDataArray()), "\n";

        $respObj = RespFacadeFactory::createHeartBeatRespObj($did, $req);
        $this->publish(['type'=>'hb', 'did'=>$did, 'time'=>time()]);
        return $respObj;
    }
}