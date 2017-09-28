<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aph300\action;


use sunsun\aph300\dal\Aph300DeviceDal;
use sunsun\aph300\resp\Aph300DeviceUpdateResp;
use sunsun\helper\ResultHelper;

class Aph300DeviceUpdateAction
{
    /**
     * 设备固件更新响应处理
     * @param $did
     * @param $clientId
     * @param Aph300DeviceUpdateResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, Aph300DeviceUpdateResp $resp)
    {

        //更新设备信息
        $updateEntity = [
            'device_state' => $resp->getState()
        ];
        $dal = new Aph300DeviceDal();
//        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));
        $updateEntity['update_time'] = time();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}