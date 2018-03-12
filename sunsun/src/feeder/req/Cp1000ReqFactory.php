<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\feeder\req;


class FeederReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case FeederReqType::Login:
                $req = new FeederLoginReq($data);
                break;
            case FeederReqType::DeviceInfo:
                $req = new FeederDeviceInfoReq($data);
                break;
            case FeederReqType::Event:
                $req = new FeederDeviceEventReq($data);
                break;
            case FeederReqType::Control:
                $req = new FeederCtrlDeviceReq($data);
                break;
            case FeederReqType::FirmwareUpdate:
                $req = new FeederDeviceUpdateServerReq($data);
                break;
            case FeederReqType::Heartbeat:
                $req = new FeederHbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}