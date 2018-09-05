<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-16
 * Time: 11:40
 */

namespace sunsun\server\factory;


use sunsun\adt\resp\AdtRespFactory;
use sunsun\aph300\resp\Aph300RespFactory;
use sunsun\aq118\resp\Aq118RespFactory;
use sunsun\aq806\resp\Aq806RespFactory;
use sunsun\cp1000\resp\Cp1000RespFactory;
use sunsun\feeder\resp\FeederRespFactory;
use sunsun\filter_vat\resp\FilterVatRespFactory;
use sunsun\heating_rod\resp\HeatingRodRespFactory;
use sunsun\pet_feeder\resp\PetFeederRespFactory;
use sunsun\server\consts\DeviceType;
use sunsun\server\consts\RespFacadeType;
use sunsun\server\req\BaseDeviceEventClientReq;
use sunsun\server\req\BaseDeviceLoginClientReq;
use sunsun\server\req\BaseHeartBeatClientReq;
use sunsun\water_pump\resp\WaterPumpRespFactory;

class RespFacadeFactory
{
    public static function createLoginRespObj($did, BaseDeviceLoginClientReq $req = null)
    {
        $jsonData = [];
        if (!empty($req)) {
            $jsonData = $req->toDataArray();
        }
        return self::createRespObj($did, RespFacadeType::LOGIN, $jsonData);
    }

    public static function createDeviceEventRespObj($did, BaseDeviceEventClientReq $req = null)
    {
        $jsonData = [];
        if (!empty($req)) {
            $jsonData = $req->toDataArray();
        }
        return self::createRespObj($did, RespFacadeType::EVENT, $jsonData);
    }

    /**
     * 创建服务器的心跳响应包
     * @param $did
     * @param BaseHeartBeatClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\aph300\resp\Aph300CtrlDeviceResp|\sunsun\aph300\resp\Aph300DeviceInfoResp|\sunsun\aph300\resp\Aph300DeviceUpdateResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\cp1000\resp\Cp1000CtrlDeviceResp|\sunsun\cp1000\resp\Cp1000DeviceFirmwareUpdateResp|\sunsun\cp1000\resp\Cp1000DeviceInfoResp|\sunsun\cp1000\resp\Cp1000HbResp|\sunsun\heating_rod\resp\HeatingRodCtrlDeviceResp|\sunsun\heating_rod\resp\HeatingRodDeviceInfoResp|\sunsun\heating_rod\resp\HeatingRodDeviceUpdateResp
     */
    public static function createHeartBeatRespObj($did, BaseHeartBeatClientReq $req = null)
    {
        $jsonData = [];
        if (!empty($req)) {
            $jsonData = $req->toDataArray();
        }
        return self::createRespObj($did, RespFacadeType::HEART_BEAT, $jsonData);
    }

    /**
     * 创建响应包
     * @param $did string 设备did
     * @param $facadeRespType string 统一响应包类型 参照DeviceType类中
     * @param $jsonData array 数据数组
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\adt\resp\AdtHbResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\aq806\resp\Aq806HbResp|\sunsun\filter_vat\resp\FilterVatCtrlDeviceResp|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|\sunsun\filter_vat\resp\FilterVatDeviceInfoResp|\sunsun\filter_vat\resp\FilterVatDeviceUpdateResp|\sunsun\filter_vat\resp\FilterVatHbResp|\sunsun\filter_vat\resp\FilterVatLoginResp|\sunsun\water_pump\resp\WaterPumpCtrlDeviceResp|\sunsun\water_pump\resp\WaterPumpDeviceInfoResp|\sunsun\water_pump\resp\WaterPumpDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpHbResp
     */
    public static function createRespObj($did, $facadeRespType, $jsonData)
    {
        $respType = RespFacadeType::getRespType($did, $facadeRespType);
        $respFactory = self::createRespFactory(DeviceType::getDeviceType($did));
        if ($respFactory != null) {
            return $respFactory->create($respType, $jsonData);
        }
        return null;
    }

    /**
     * @param $deviceType
     * @return null|AdtRespFactory|Aph300RespFactory|Aq806RespFactory|Cp1000RespFactory|HeatingRodRespFactory|WaterPumpRespFactory|FilterVatRespFactory
     */
    public static function createRespFactory($deviceType)
    {
        $factory = null;
        switch ($deviceType) {
            case DeviceType::Did_PetFeeder:
                $factory = new PetFeederRespFactory();
                break;
            case DeviceType::Did_CP1000:
                $factory = new Cp1000RespFactory();
                break;
            case DeviceType::Did_ADT:
                $factory = new AdtRespFactory();
                break;
            case DeviceType::Did_HeatingRod:
                $factory = new HeatingRodRespFactory();
                break;
            case DeviceType::Did_APH300:
                $factory = new Aph300RespFactory();
                break;
            case DeviceType::Did_AQ806:
                $factory = new Aq806RespFactory();
                break;
            case DeviceType::Did_WaterPump:
                $factory = new WaterPumpRespFactory();
                break;
            case DeviceType::Did_FilterVat:
                $factory = new FilterVatRespFactory();
                break;
            case DeviceType::Did_AQ118:
                $factory = new Aq118RespFactory();
                break;
            case DeviceType::Did_Feeder:
                $factory = new FeederRespFactory();
                break;
            default:
                break;
        }
        return $factory;
    }


}