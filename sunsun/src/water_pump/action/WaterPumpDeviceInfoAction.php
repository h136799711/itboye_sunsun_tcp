<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\water_pump\action;


use sunsun\helper\ResultHelper;
use sunsun\water_pump\dal\WaterPumpDeviceDal;
use sunsun\water_pump\helper\ModelConverterHelper;
use sunsun\water_pump\helper\WaterPumpTcpLogHelper;
use sunsun\water_pump\resp\WaterPumpDeviceInfoResp;

class WaterPumpDeviceInfoAction
{
    public function updateInfo($did, $clientId, WaterPumpDeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new WaterPumpDeviceDal();
        WaterPumpTcpLogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}