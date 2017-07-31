<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\adt\action;


use sunsun\adt\dal\AdtDeviceDal;
use sunsun\adt\resp\AdtDeviceUpdateResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class AdtDeviceUpdateAction
{
    /**
     * 设备固件更新响应处理
     * @param $did
     * @param $clientId
     * @param AdtDeviceUpdateResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, AdtDeviceUpdateResp $resp)
    {

        //更新设备信息
        $updateEntity = [
            'device_state' => $resp->getState()
        ];
        $dal = new AdtDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}