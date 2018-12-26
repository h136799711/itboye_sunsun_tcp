<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\feederV2\req;


class FeederV2ReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case FeederV2ReqType::Login:
                $req = new FeederV2LoginReq($data);
                break;
            case FeederV2ReqType::DeviceInfo:
                $req = new FeederV2DeviceInfoReq($data);
                break;
            case FeederV2ReqType::Event:
                $req = new FeederV2DeviceEventReq($data);
                break;
            case FeederV2ReqType::Control:
                $req = new FeederV2CtrlDeviceReq($data);
                break;
            case FeederV2ReqType::FirmwareUpdate:
                $req = new FeederV2DeviceUpdateServerReq($data);
                break;
            case FeederV2ReqType::Heartbeat:
                $req = new FeederV2HbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}