<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\water_pump\req;


class WaterPumpReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case WaterPumpReqType::Login:
                $req = new WaterPumpLoginReq($data);
                break;
            case WaterPumpReqType::DeviceInfo:
                $req = new WaterPumpDeviceInfoReq($data);
                break;
            case WaterPumpReqType::Event:
                $req = new WaterPumpDeviceEventReq($data);
                break;
            case WaterPumpReqType::Control:
                $req = new WaterPumpCtrlDeviceReq($data);
                break;
            case WaterPumpReqType::FirmwareUpdate:
                $req = new WaterPumpDeviceUpdateReq($data);
                break;
            case WaterPumpReqType::Heartbeat:
                $req = new WaterPumpHbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}