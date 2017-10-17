<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\aq806\resp;

class Aq806RespFactory
{

    public static function create($resType, $jsonData)
    {
        $sn = $jsonData['sn'];

        $resp = null;
        switch ($resType) {
            case Aq806RespType::Heartbeat:
                $resp = new Aq806HbResp();
                $resp->setData($jsonData);
                break;
            case Aq806RespType::Control:
                $resp = new Aq806CtrlDeviceResp();
                $resp->setData($jsonData);
                break;
            case Aq806RespType::DeviceInfo:
                $resp = new Aq806DeviceInfoResp();
                $resp->setData($jsonData);
                break;
            case Aq806RespType::FirmwareUpdate:
                $resp = new Aq806DeviceUpdateResp();
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