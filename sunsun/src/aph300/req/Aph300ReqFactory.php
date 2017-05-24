<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aph300\req;


class Aph300ReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case Aph300ReqType::Login:
                $req = new Aph300LoginReq($data);
                break;
            case Aph300ReqType::DeviceInfo:
                $req = new Aph300DeviceInfoReq($data);
                break;
            case Aph300ReqType::Event:
                $req = new Aph300DeviceEventReq($data);
                break;
            case Aph300ReqType::Control:
                break;
            case Aph300ReqType::FirmwareUpdate:
                break;
            case Aph300ReqType::Heartbeat:
                $req = new Aph300HbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}