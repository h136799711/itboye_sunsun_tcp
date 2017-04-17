<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aq806\action;


use sunsun\aq806\dal\Aq806DeviceDal;
use sunsun\aq806\resp\Aq806CtrlDeviceResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\aq806\helper\ModelConverterHelper;

class Aq806DeviceCtrlAction
{
    /**
     * 设备控制响应类似设备获取信息处理
     * 也是更新设备信息
     * @param $did
     * @param $clientId
     * @param Aq806CtrlDeviceResp $resp
     * @return array
     */
    public function updateInfo($did,$clientId,Aq806CtrlDeviceResp $resp){
        $check = $resp->check();
        if(!empty($check)){
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArrayOfCtrlDeviceResp($resp);
        $dal = new Aq806DeviceDal();
        LogHelper::logDebug($clientId,'updateEntity'.json_encode($updateEntity));

        $ret = $dal->updateByDid($did,$updateEntity);
        return ResultHelper::success($ret);
    }

}