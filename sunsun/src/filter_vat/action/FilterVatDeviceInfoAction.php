<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\filter_vat\action;


use GatewayWorker\Lib\Gateway;
use sunsun\filter_vat\dal\FilterVatDeviceDal;
use sunsun\filter_vat\resp\FilterVatDeviceInfoResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\filter_vat\helper\ModelConverterHelper;

class FilterVatDeviceInfoAction
{
    public function updateInfo($did,$clientId,FilterVatDeviceInfoResp $resp){
        $check = $resp->check();
        if(!empty($check)){
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new FilterVatDeviceDal();
        LogHelper::logDebug($clientId,'updateEntity'.json_encode($updateEntity));

        $ret = $dal->updateByDid($did,$updateEntity);
        return ResultHelper::success($ret);
    }

}