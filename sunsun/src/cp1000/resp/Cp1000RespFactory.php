<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\cp1000\resp;

class Cp1000RespFactory
{

    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case Cp1000RespType::Heartbeat:
                $resp = new Cp1000HbResp();
                break;
            case Cp1000RespType::Control:
                $resp = new Cp1000CtrlDeviceResp();
                break;
            case Cp1000RespType::DeviceInfo:
                $resp = new Cp1000DeviceInfoResp();
                break;
            case Cp1000RespType::FirmwareUpdate:
                $resp = new Cp1000DeviceFirmwareUpdateResp();
                break;
            case Cp1000RespType::Login:
                $resp = new Cp1000LoginResp();
                break;
            case Cp1000RespType::Event:
                $resp = new Cp1000DeviceEventResp();
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