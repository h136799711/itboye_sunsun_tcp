<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\heating_rod\action;


use GatewayWorker\Lib\Gateway;
use sunsun\heating_rod\dal\HeatingRodDeviceDal;
use sunsun\heating_rod\resp\HeatingRodDeviceInfoResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\heating_rod\helper\ModelConverterHelper;

class HeatingRodDeviceInfoAction
{
    public function updateInfo($did,$clientId,HeatingRodDeviceInfoResp $resp){
        $check = $resp->check();
        if(!empty($check)){
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new HeatingRodDeviceDal();
        LogHelper::logDebug($clientId,'updateEntity'.json_encode($updateEntity));

        $ret = $dal->updateByDid($did,$updateEntity);
        return ResultHelper::success($ret);
    }

}