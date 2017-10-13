<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;


use sunsun\cp1000\dal\Cp1000DeviceDal;
use sunsun\cp1000\resp\Cp1000DeviceUpdateResp;
use sunsun\helper\ResultHelper;

class Cp1000DeviceUpdateAction
{
    /**
     * 设备固件更新响应处理
     * @param $did
     * @param $clientId
     * @param Cp1000DeviceUpdateResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, Cp1000DeviceUpdateResp $resp)
    {

        //更新设备信息
        $updateEntity = [
            'device_state' => $resp->getState()
        ];
        $dal = new Cp1000DeviceDal();
        $updateEntity['update_time'] = time();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}