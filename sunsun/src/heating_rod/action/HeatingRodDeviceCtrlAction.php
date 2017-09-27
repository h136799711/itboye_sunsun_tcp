<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\heating_rod\action;


use sunsun\heating_rod\dal\HeatingRodDeviceDal;
use sunsun\heating_rod\helper\ModelConverterHelper;
use sunsun\heating_rod\resp\HeatingRodCtrlDeviceResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\TransferClient;

class HeatingRodDeviceCtrlAction
{
    /**
     * 设备控制响应类似设备获取信息处理
     * 也是更新设备信息
     * @param $did
     * @param $clientId
     * @param HeatingRodCtrlDeviceResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, HeatingRodCtrlDeviceResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArrayOfCtrlDeviceResp($resp);
        $dal = new HeatingRodDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity,$resp->getSn());
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}