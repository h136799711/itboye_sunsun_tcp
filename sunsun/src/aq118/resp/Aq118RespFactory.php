<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aq118\resp;

class Aq118RespFactory
{

    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case Aq118RespType::Heartbeat:
                $resp = new Aq118HbResp();
                break;
            case Aq118RespType::Control:
                $resp = new Aq118CtrlDeviceResp();
                break;
            case Aq118RespType::DeviceInfo:
                $resp = new Aq118DeviceInfoResp();
                break;
            case Aq118RespType::FirmwareUpdate:
                $resp = new Aq118DeviceUpdateResp();
                break;
            case Aq118RespType::Event:
                $resp = new Aq118DeviceEventResp();
                break;
            case Aq118RespType::Login:
                $resp = new Aq118LoginResp();
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