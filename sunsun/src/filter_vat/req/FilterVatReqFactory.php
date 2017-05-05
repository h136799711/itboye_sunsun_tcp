<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:32
 */

namespace sunsun\filter_vat\req;


class FilterVatReqFactory
{
    public static function create($type, $data)
    {
        $req = null;
        switch ($type) {
            case FilterVatReqType::Login:
                $req = new FilterVatLoginReq($data);
                break;
            case FilterVatReqType::DeviceInfo:
                $req = new FilterVatDeviceInfoReq($data);
                break;
            case FilterVatReqType::Event:
                $req = new FilterVatDeviceEventReq($data);
                break;
            case FilterVatReqType::Control:
                break;
            case FilterVatReqType::FirmwareUpdate:
                break;
            case FilterVatReqType::Heartbeat:
                $req = new FilterVatHbReq($data);
                break;
            default:
                break;
        }
        return $req;
    }
}