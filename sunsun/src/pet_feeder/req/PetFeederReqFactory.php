<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\pet_feeder\req;


class PetFeederReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case PetFeederReqType::Login:
                $req = new PetFeederLoginReq($data);
                break;
            case PetFeederReqType::DeviceInfo:
                $req = new PetFeederDeviceInfoReq($data);
                break;
            case PetFeederReqType::Event:
                $req = new PetFeederDeviceEventReq($data);
                break;
            case PetFeederReqType::Control:
                $req = new PetFeederCtrlDeviceReq($data);
                break;
            case PetFeederReqType::FirmwareUpdate:
                $req = new PetFeederDeviceUpdateServerReq($data);
                break;
            case PetFeederReqType::Heartbeat:
                $req = new PetFeederHbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}