<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\adt\action;


use sunsun\adt\dal\AdtDeviceDal;
use sunsun\adt\helper\ModelConverterHelper;
use sunsun\adt\resp\AdtDeviceInfoResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class AdtDeviceInfoAction
{
    public function updateInfo($did, $clientId, AdtDeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new AdtDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}