<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aq806\req;


class Aq806ReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case Aq806ReqType::Login:
                $req = new Aq806LoginReq($data);
                break;
            case Aq806ReqType::DeviceInfo:
                $req = new Aq806DeviceInfoReq($data);
                break;
            case Aq806ReqType::Event:
                $req = new Aq806DeviceEventReq($data);
                break;
            case Aq806ReqType::Control:
                break;
            case Aq806ReqType::FirmwareUpdate:
                break;
            case Aq806ReqType::Heartbeat:
                $req = new Aq806HbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}