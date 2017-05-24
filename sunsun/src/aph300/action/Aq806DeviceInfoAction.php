<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aph300\action;


use sunsun\aph300\dal\Aph300DeviceDal;
use sunsun\aph300\helper\ModelConverterHelper;
use sunsun\aph300\resp\Aph300DeviceInfoResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class Aph300DeviceInfoAction
{
    public function updateInfo($did, $clientId, Aph300DeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new Aph300DeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}