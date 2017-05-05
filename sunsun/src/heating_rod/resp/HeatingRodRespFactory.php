<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\heating_rod\resp;

class HeatingRodRespFactory
{
    public static function create($resType, $jsonData)
    {
        $sn = $jsonData['sn'];

        $resp = null;
        switch ($resType) {
            case HeatingRodRespType::Control:
                $resp = new HeatingRodCtrlDeviceResp();
                $resp->setData($jsonData);
                break;
            case HeatingRodRespType::DeviceInfo:
                $resp = new HeatingRodDeviceInfoResp();
                $resp->setData($jsonData);
                break;
            case HeatingRodRespType::FirmwareUpdate:
                $resp = new HeatingRodDeviceUpdateResp();
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