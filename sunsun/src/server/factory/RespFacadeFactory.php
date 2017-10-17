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
use sunsun\aq806\resp\Aq806RespFactory;
use sunsun\cp1000\resp\Cp1000RespFactory;
use sunsun\filter_vat\resp\FilterVatRespFactory;
use sunsun\heating_rod\resp\HeatingRodRespFactory;
use sunsun\server\consts\DeviceType;
use sunsun\server\consts\RespFacadeType;
use sunsun\water_pump\resp\WaterPumpRespFactory;

class RespFacadeFactory
{
    /**
     * 创建响应包
     * @param $did string 设备did
     * @param $facadeRespType string 统一响应包类型 参照DeviceType类中
     * @param $jsonData array 数据数组
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\aph300\resp\Aph300CtrlDeviceResp|\sunsun\aph300\resp\Aph300DeviceInfoResp|\sunsun\aph300\resp\Aph300DeviceUpdateResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\cp1000\resp\Cp1000CtrlDeviceResp|\sunsun\cp1000\resp\Cp1000DeviceFirmwareUpdateResp|\sunsun\cp1000\resp\Cp1000DeviceInfoResp|\sunsun\cp1000\resp\Cp1000HbResp|\sunsun\heating_rod\resp\HeatingRodCtrlDeviceResp|\sunsun\heating_rod\resp\HeatingRodDeviceInfoResp|\sunsun\heating_rod\resp\HeatingRodDeviceUpdateResp
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
     * @return null|AdtRespFactory|Aph300RespFactory|Aq806RespFactory|Cp1000RespFactory|HeatingRodRespFactory|WaterPumpRespFactory
     */
    public static function createRespFactory($deviceType)
    {
        $factory = null;
        switch ($deviceType) {
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
            default:
                break;
        }
        return $factory;
    }


}