<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aph300\resp;

class Aph300RespFactory
{
    public static function create($resType, $jsonData)
    {
        $sn = $jsonData['sn'];

        $resp = null;
        switch ($resType) {
            case Aph300RespType::Heartbeat:
                $resp = new Aph300HbResp();
                $resp->setData($jsonData);
                break;
            case Aph300RespType::Control:
                $resp = new Aph300CtrlDeviceResp();
                $resp->setData($jsonData);
                break;
            case Aph300RespType::DeviceInfo:
                $resp = new Aph300DeviceInfoResp();
                $resp->setData($jsonData);
                break;
            case Aph300RespType::FirmwareUpdate:
                $resp = new Aph300DeviceUpdateResp();
                $resp->setData($jsonData);
                break;
            default:
                break;
        }

        if ($resp) {
            $resp->setSn($sn);
        }

        return $resp;
    }
}