<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\adt\action;


use sunsun\adt\dal\AdtDeviceDal;
use sunsun\adt\helper\AdtTcpLogHelper;
use sunsun\adt\helper\ModelConverterHelper;
use sunsun\adt\resp\AdtCtrlDeviceResp;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\TransferClient;

class AdtDeviceCtrlAction
{
    /**
     * 设备控制响应类似设备获取信息处理
     * 也是更新设备信息
     * @param $did
     * @param $clientId
     * @param AdtCtrlDeviceResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, AdtCtrlDeviceResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArrayOfCtrlDeviceResp($resp);
        $dal = new AdtDeviceDal();
        AdtTcpLogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity),"AdtDeviceCtrlAction");
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity,$resp->getSn());
        $updateEntity['update_time'] = time();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}