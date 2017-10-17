<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;


use sunsun\cp1000\dal\Cp1000DeviceDal;
use sunsun\cp1000\helper\ModelConverterHelper;
use sunsun\cp1000\resp\Cp1000CtrlDeviceResp;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\TransferClient;

class Cp1000DeviceCtrlAction
{
    /**
     * 设备控制响应类似设备获取信息处理
     * 也是更新设备信息
     * @param $did
     * @param $clientId
     * @param Cp1000CtrlDeviceResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, Cp1000CtrlDeviceResp $resp)
    {
        $dal = new Cp1000DeviceDal();
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArrayOfCtrlDeviceResp($resp);
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn());
        $updateEntity['update_time'] = time();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}