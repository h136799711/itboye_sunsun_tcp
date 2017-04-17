<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aq806\action;


use sunsun\aq806\dal\Aq806DeviceDal;
use sunsun\aq806\resp\Aq806DeviceUpdateResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class Aq806DeviceUpdateAction
{
    /**
     * 设备固件更新响应处理
     * @param $did
     * @param $clientId
     * @param Aq806DeviceUpdateResp $resp
     * @return array
     */
    public function updateInfo($did,$clientId,Aq806DeviceUpdateResp $resp){

        //更新设备信息
        $updateEntity = [
            'device_state'=>$resp->getState()
        ];
        $dal = new Aq806DeviceDal();
        LogHelper::logDebug($clientId,'updateEntity'.json_encode($updateEntity));

        $ret = $dal->updateByDid($did,$updateEntity);
        return ResultHelper::success($ret);
    }

}