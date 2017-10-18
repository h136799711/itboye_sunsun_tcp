<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aph300\resp;

class Aph300RespFactory
{
    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case Aph300RespType::Heartbeat:
                $resp = new Aph300HbResp();
                break;
            case Aph300RespType::Control:
                $resp = new Aph300CtrlDeviceResp();
                break;
            case Aph300RespType::DeviceInfo:
                $resp = new Aph300DeviceInfoResp();
                break;
            case Aph300RespType::FirmwareUpdate:
                $resp = new Aph300DeviceUpdateResp();
                break;
            case Aph300RespType::Login:
                $resp = new Aph300LoginResp();
                break;
            case Aph300RespType::Event:
                $resp = new Aph300DeviceEventResp();
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