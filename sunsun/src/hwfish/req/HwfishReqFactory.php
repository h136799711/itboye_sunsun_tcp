<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\hwfish\req;


class HwfishReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case HwfishReqType::Login:
                $req = new HwfishLoginReq($data);
                break;
            case HwfishReqType::DeviceInfo:
                $req = new HwfishDeviceInfoReq($data);
                break;
            case HwfishReqType::Event:
                $req = new HwfishDeviceEventReq($data);
                break;
            case HwfishReqType::Control:
                $req = new HwfishCtrlDeviceReq($data);
                break;
            case HwfishReqType::FirmwareUpdate:
                $req = new HwfishDeviceUpdateReq($data);
                break;
            case HwfishReqType::Heartbeat:
                $req = new HwfishHbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}