<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aq136\req;


class Aq136ReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case Aq136ReqType::Login:
                $req = new Aq136LoginReq($data);
                break;
            case Aq136ReqType::DeviceInfo:
                $req = new Aq136DeviceInfoReq($data);
                break;
            case Aq136ReqType::Event:
                $req = new Aq136DeviceEventReq($data);
                break;
            case Aq136ReqType::Control:
                $req = new Aq136CtrlDeviceReq($data);
                break;
            case Aq136ReqType::FirmwareUpdate:
                $req = new Aq136DeviceUpdateReq($data);
                break;
            case Aq136ReqType::Heartbeat:
                $req = new Aq136HbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}