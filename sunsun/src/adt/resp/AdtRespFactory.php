<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\adt\resp;

class AdtRespFactory
{
    public static function create($resType, $jsonData)
    {
        $sn = $jsonData['sn'];

        $resp = null;
        switch ($resType) {
            case AdtRespType::Control:
                $resp = new AdtCtrlDeviceResp();
                $resp->setData($jsonData);
                break;
            case AdtRespType::DeviceInfo:
                $resp = new AdtDeviceInfoResp();
                $resp->setData($jsonData);
                break;
            case AdtRespType::FirmwareUpdate:
                $resp = new AdtDeviceUpdateResp();
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