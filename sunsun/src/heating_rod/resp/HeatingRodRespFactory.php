<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\heating_rod\resp;

class HeatingRodRespFactory
{
    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case HeatingRodRespType::Heartbeat:
                $resp = new HeatingRodHbResp();
                break;
            case HeatingRodRespType::Control:
                $resp = new HeatingRodCtrlDeviceResp();
                break;
            case HeatingRodRespType::DeviceInfo:
                $resp = new HeatingRodDeviceInfoResp();
                break;
            case HeatingRodRespType::FirmwareUpdate:
                $resp = new HeatingRodDeviceUpdateResp();
                break;
            case HeatingRodRespType::Login:
                $resp = new HeatingRodLoginResp();
                break;
            case HeatingRodRespType::Event:
                $resp = new HeatingRodDeviceEventResp();
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