<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aq806\action;


use sunsun\aq806\dal\Aq806DeviceDal;
use sunsun\aq806\helper\ModelConverterHelper;
use sunsun\aq806\resp\Aq806DeviceInfoResp;
use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class Aq806DeviceInfoAction
{
    public function updateInfo($did, $clientId, Aq806DeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new Aq806DeviceDal();
        $avg = DevToServerDelayHelper::logRespTime($clientId,$resp);
        if($avg > 12345679.999){
            $avg = 12345679.999;
        }
        if($avg > 0) {
            $updateEntity['delay_avg'] = $avg;
        }
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }




}