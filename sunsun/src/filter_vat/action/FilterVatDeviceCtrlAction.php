<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\filter_vat\action;


use sunsun\filter_vat\dal\FilterVatDeviceDal;
use sunsun\filter_vat\helper\ModelConverterHelper;
use sunsun\filter_vat\resp\FilterVatCtrlDeviceResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class FilterVatDeviceCtrlAction
{
    /**
     * 设备控制响应类似设备获取信息处理
     * 也是更新设备信息
     * @param $did
     * @param $clientId
     * @param FilterVatCtrlDeviceResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, FilterVatCtrlDeviceResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArrayOfCtrlDeviceResp($resp);
        $dal = new FilterVatDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}