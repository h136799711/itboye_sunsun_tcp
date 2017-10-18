<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aq806\resp;

class Aq806RespFactory
{

    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case Aq806RespType::Heartbeat:
                $resp = new Aq806HbResp();
                break;
            case Aq806RespType::Control:
                $resp = new Aq806CtrlDeviceResp();
                break;
            case Aq806RespType::DeviceInfo:
                $resp = new Aq806DeviceInfoResp();
                break;
            case Aq806RespType::FirmwareUpdate:
                $resp = new Aq806DeviceUpdateResp();
                break;
            case Aq806RespType::Event:
                $resp = new Aq806DeviceEventResp();
                break;
            case Aq806RespType::Login:
                $resp = new Aq806LoginResp();
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