<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\adt\resp;

class AdtRespFactory
{
    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case AdtRespType::Heartbeat:
                $resp = new AdtHbResp();
                break;
            case AdtRespType::Control:
                $resp = new AdtCtrlDeviceResp();
                break;
            case AdtRespType::DeviceInfo:
                $resp = new AdtDeviceInfoResp();
                break;
            case AdtRespType::FirmwareUpdate:
                $resp = new AdtDeviceUpdateResp();
                break;
            case AdtRespType::Login:
                $resp = new AdtLoginResp();
                break;
            case AdtRespType::Event:
                $resp = new AdtDeviceEventResp();
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