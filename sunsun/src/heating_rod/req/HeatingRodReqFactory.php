<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\heating_rod\req;


class HeatingRodReqFactory
{
    public static  function create($type,$data){
        $req = null;
        switch ($type){
            case HeatingRodReqType::Login:
                $req = new HeatingRodLoginReq($data);
                break;
            case HeatingRodReqType::DeviceInfo:
                $req = new HeatingRodDeviceInfoReq($data);
                break;
            case HeatingRodReqType::Event:
                $req = new HeatingRodDeviceEventReq($data);
                break;
            case HeatingRodReqType::Control:
                break;
            case HeatingRodReqType::FirmwareUpdate:
                break;
            case HeatingRodReqType::Heartbeat:
                $req = new HeatingRodHbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}