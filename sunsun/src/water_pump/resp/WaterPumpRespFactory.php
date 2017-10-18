<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\water_pump\resp;

class WaterPumpRespFactory
{
    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case WaterPumpRespType::Heartbeat:
                $resp = new WaterPumpHbResp();
                break;
            case WaterPumpRespType::Control:
                $resp = new WaterPumpCtrlDeviceResp();
                break;
            case WaterPumpRespType::DeviceInfo:
                $resp = new WaterPumpDeviceInfoResp();
                break;
            case WaterPumpRespType::FirmwareUpdate:
                $resp = new WaterPumpDeviceUpdateResp();
                break;
            case WaterPumpRespType::Login:
                $resp = new WaterPumpLoginResp();
                break;
            case WaterPumpRespType::Event:
                $resp = new WaterPumpDeviceEventResp();
                break;
            default:
                break;
        }

        if ($resp) {
            $resp->setData($jsonData);
        }

        return $resp;
    }
}