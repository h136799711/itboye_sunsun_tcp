<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\feederV2\resp;

class FeederV2RespFactory
{

    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case FeederV2RespType::Heartbeat:
                $resp = new FeederV2HbResp();
                break;
            case FeederV2RespType::Control:
                $resp = new FeederV2CtrlDeviceResp();
                break;
            case FeederV2RespType::DeviceInfo:
                $resp = new FeederV2DeviceInfoResp();
                break;
            case FeederV2RespType::FirmwareUpdate:
                $resp = new FeederV2DeviceFirmwareUpdateResp();
                break;
            case FeederV2RespType::Login:
                $resp = new FeederV2LoginResp();
                break;
            case FeederV2RespType::Event:
                $resp = new FeederV2DeviceEventResp();
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