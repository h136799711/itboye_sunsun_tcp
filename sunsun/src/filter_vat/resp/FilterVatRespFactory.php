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
    public static  function create($resType,$jsonData){
        $sn = $jsonData['sn'];

        $resp = null;
        switch ($resType){
            case FilterVatRespType::Control:
                $resp = new FilterVatCtrlDeviceResp();
                $resp->setData($jsonData);
                break;
            case FilterVatRespType::DeviceInfo:
                $resp = new FilterVatDeviceInfoResp();
                $resp->setData($jsonData);
                break;
            case FilterVatRespType::FirmwareUpdate:
                $resp = new FilterVatDeviceUpdateResp();
                $resp->setData($jsonData);
                break;
            default:
                break;
        }

        if($resp){
            $resp->setSn($sn);
        }

        return $resp;
    }
}