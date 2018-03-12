<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\feeder\resp;

class FeederRespFactory
{

    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case FeederRespType::Heartbeat:
                $resp = new FeederHbResp();
                break;
            case FeederRespType::Control:
                $resp = new FeederCtrlDeviceResp();
                break;
            case FeederRespType::DeviceInfo:
                $resp = new FeederDeviceInfoResp();
                break;
            case FeederRespType::FirmwareUpdate:
                $resp = new FeederDeviceFirmwareUpdateResp();
                break;
            case FeederRespType::Login:
                $resp = new FeederLoginResp();
                break;
            case FeederRespType::Event:
                $resp = new FeederDeviceEventResp();
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