<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aq136\resp;

class Aq136RespFactory
{

    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case Aq136RespType::Heartbeat:
                $resp = new Aq136HbResp();
                break;
            case Aq136RespType::Control:
                $resp = new Aq136CtrlDeviceResp();
                break;
            case Aq136RespType::DeviceInfo:
                $resp = new Aq136DeviceInfoResp();
                break;
            case Aq136RespType::FirmwareUpdate:
                $resp = new Aq136DeviceUpdateResp();
                break;
            case Aq136RespType::Event:
                $resp = new Aq136DeviceEventResp();
                break;
            case Aq136RespType::Login:
                $resp = new Aq136LoginResp();
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