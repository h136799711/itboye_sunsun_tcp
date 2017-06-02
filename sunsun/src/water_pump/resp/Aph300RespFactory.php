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
        $sn = $jsonData['sn'];

        $resp = null;
        switch ($resType) {
            case WaterPumpRespType::Control:
                $resp = new WaterPumpCtrlDeviceResp();
                $resp->setData($jsonData);
                break;
            case WaterPumpRespType::DeviceInfo:
                $resp = new WaterPumpDeviceInfoResp();
                $resp->setData($jsonData);
                break;
            case WaterPumpRespType::FirmwareUpdate:
                $resp = new WaterPumpDeviceUpdateResp();
                $resp->setData($jsonData);
                break;
            default:
                break;
        }

        if ($resp) {
            $resp->setSn($sn);
        }

        return $resp;
    }
}