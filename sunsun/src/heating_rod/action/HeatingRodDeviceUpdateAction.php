<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\heating_rod\action;


use sunsun\heating_rod\dal\HeatingRodDeviceDal;
use sunsun\heating_rod\resp\HeatingRodDeviceUpdateResp;
use sunsun\helper\ResultHelper;

class HeatingRodDeviceUpdateAction
{
    /**
     * 设备固件更新响应处理
     * @param $did
     * @param $clientId
     * @param HeatingRodDeviceUpdateResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, HeatingRodDeviceUpdateResp $resp)
    {

        //更新设备信息
        $updateEntity = [
            'device_state' => $resp->getState()
        ];
        $dal = new HeatingRodDeviceDal();

        $updateEntity['update_time'] = time();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}