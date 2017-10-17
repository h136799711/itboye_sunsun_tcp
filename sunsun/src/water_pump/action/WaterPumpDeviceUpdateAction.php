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
use sunsun\water_pump\resp\WaterPumpDeviceUpdateResp;

class WaterPumpDeviceUpdateAction
{
    /**
     * 设备固件更新响应处理
     * @param $did
     * @param $clientId
     * @param WaterPumpDeviceUpdateResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, WaterPumpDeviceUpdateResp $resp)
    {

        //更新设备信息
        $updateEntity = [
            'device_state' => $resp->getState(),
            'update_time' => time()
        ];
        $dal = new WaterPumpDeviceDal();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}