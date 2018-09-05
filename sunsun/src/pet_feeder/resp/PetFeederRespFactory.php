<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\pet_feeder\resp;

class PetFeederRespFactory
{

    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case PetFeederRespType::Heartbeat:
                $resp = new PetFeederHbResp();
                break;
            case PetFeederRespType::Control:
                $resp = new PetFeederCtrlDeviceResp();
                break;
            case PetFeederRespType::DeviceInfo:
                $resp = new PetFeederDeviceInfoResp();
                break;
            case PetFeederRespType::FirmwareUpdate:
                $resp = new PetFeederDeviceFirmwareUpdateResp();
                break;
            case PetFeederRespType::Login:
                $resp = new PetFeederLoginResp();
                break;
            case PetFeederRespType::Event:
                $resp = new PetFeederDeviceEventResp();
                break;
            default:
                break;
        }

        if ($resp) {
            $resp->setData($jsonData);
        }

        return $resp;
    }
}