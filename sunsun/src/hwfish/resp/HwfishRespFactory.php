<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\hwfish\resp;

class HwfishRespFactory
{

    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case HwfishRespType::Heartbeat:
                $resp = new HwfishHbResp();
                break;
            case HwfishRespType::Control:
                $resp = new HwfishCtrlDeviceResp();
                break;
            case HwfishRespType::DeviceInfo:
                $resp = new HwfishDeviceInfoResp();
                break;
            case HwfishRespType::FirmwareUpdate:
                $resp = new HwfishDeviceUpdateResp();
                break;
            case HwfishRespType::Event:
                $resp = new HwfishDeviceEventResp();
                break;
            case HwfishRespType::Login:
                $resp = new HwfishLoginResp();
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