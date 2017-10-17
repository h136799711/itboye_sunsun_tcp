<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\cp1000\resp;

class Cp1000RespFactory
{
    public static function create($resType, $jsonData)
    {
        $sn = $jsonData['sn'];

        $resp = null;
        switch ($resType) {
            case Cp1000RespType::Control:
                $resp = new Cp1000CtrlDeviceResp();
                $resp->setData($jsonData);
                break;
            case Cp1000RespType::DeviceInfo:
                $resp = new Cp1000DeviceInfoResp();
                $resp->setData($jsonData);
                break;
            case Cp1000RespType::FirmwareUpdate:
                $resp = new Cp1000DeviceFirmwareUpdateResp();
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