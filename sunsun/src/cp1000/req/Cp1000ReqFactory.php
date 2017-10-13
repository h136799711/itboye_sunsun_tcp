<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\cp1000\req;


class Cp1000ReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case Cp1000ReqType::Login:
                $req = new Cp1000LoginReq($data);
                break;
            case Cp1000ReqType::DeviceInfo:
                $req = new Cp1000DeviceInfoReq($data);
                break;
            case Cp1000ReqType::Event:
                $req = new Cp1000DeviceEventReq($data);
                break;
            case Cp1000ReqType::Control:
                break;
            case Cp1000ReqType::FirmwareUpdate:
                break;
            case Cp1000ReqType::Heartbeat:
                $req = new Cp1000HbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}