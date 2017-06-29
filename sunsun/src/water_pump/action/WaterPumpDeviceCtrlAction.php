<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\water_pump\action;


use sunsun\water_pump\dal\WaterPumpDeviceDal;
use sunsun\water_pump\helper\WaterPumpTcpLogHelper;
use sunsun\water_pump\helper\ModelConverterHelper;
use sunsun\water_pump\resp\WaterPumpCtrlDeviceResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class WaterPumpDeviceCtrlAction
{
    /**
     * 设备控制响应类似设备获取信息处理
     * 也是更新设备信息
     * @param $did
     * @param $clientId
     * @param WaterPumpCtrlDeviceResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, WaterPumpCtrlDeviceResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArrayOfCtrlDeviceResp($resp);
        $dal = new WaterPumpDeviceDal();
        WaterPumpTcpLogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity),"WaterPumpDeviceCtrlAction");
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}