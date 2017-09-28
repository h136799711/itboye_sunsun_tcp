<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\filter_vat\action;


use sunsun\filter_vat\dal\FilterVatDeviceDal;
use sunsun\filter_vat\resp\FilterVatDeviceUpdateResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class FilterVatDeviceUpdateAction
{
    /**
     * 设备固件更新响应处理
     * @param $did
     * @param $clientId
     * @param FilterVatDeviceUpdateResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, FilterVatDeviceUpdateResp $resp)
    {

        //更新设备信息
        $updateEntity = [
            'device_state' => $resp->getState()
        ];
        $dal = new FilterVatDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        $updateEntity['update_time'] = time();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}