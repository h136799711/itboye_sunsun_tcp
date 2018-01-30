<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aq118\req;


class Aq118ReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case Aq118ReqType::Login:
                $req = new Aq118LoginReq($data);
                break;
            case Aq118ReqType::DeviceInfo:
                $req = new Aq118DeviceInfoReq($data);
                break;
            case Aq118ReqType::Event:
                $req = new Aq118DeviceEventReq($data);
                break;
            case Aq118ReqType::Control:
                $req = new Aq118CtrlDeviceReq($data);
                break;
            case Aq118ReqType::FirmwareUpdate:
                $req = new Aq118DeviceUpdateReq($data);
                break;
            case Aq118ReqType::Heartbeat:
                $req = new Aq118HbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}