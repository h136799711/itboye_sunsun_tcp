<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\adt\req;


class AdtReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case AdtReqType::Login:
                $req = new AdtLoginReq($data);
                break;
            case AdtReqType::DeviceInfo:
                $req = new AdtDeviceInfoReq($data);
                break;
            case AdtReqType::Event:
                $req = new AdtDeviceEventReq($data);
                break;
            case AdtReqType::Control:
                break;
            case AdtReqType::FirmwareUpdate:
                break;
            case AdtReqType::Heartbeat:
                $req = new AdtHbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}