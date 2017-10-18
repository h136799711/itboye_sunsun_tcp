<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\filter_vat\resp;

class FilterVatRespFactory
{
    public static function create($resType, $jsonData)
    {
        $resp = null;
        switch ($resType) {
            case FilterVatRespType::Event:
                $resp = new FilterVatDeviceEventResp();
                break;
            case FilterVatRespType::Heartbeat:
                $resp = new FilterVatHbResp();
                break;
            case FilterVatRespType::Control:
                $resp = new FilterVatCtrlDeviceResp();
                break;
            case FilterVatRespType::DeviceInfo:
                $resp = new FilterVatDeviceInfoResp();
                break;
            case FilterVatRespType::FirmwareUpdate:
                $resp = new FilterVatDeviceUpdateResp();
                break;
            case FilterVatRespType::Login:
                $resp = new FilterVatLoginResp();
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