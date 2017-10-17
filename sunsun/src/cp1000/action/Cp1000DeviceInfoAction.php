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
use sunsun\cp1000\resp\Cp1000DeviceInfoResp;
use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\TransferClient;

class Cp1000DeviceInfoAction
{
    public function updateInfo($did, $clientId, Cp1000DeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new Cp1000DeviceDal();
        $avg = DevToServerDelayHelper::logRespTime($clientId, $resp);
        if ($avg > 12345679.999) {
            $avg = 12345679.999;
        }
        if ($avg > 0) {
            $updateEntity['delay_avg'] = $avg;
        }
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn());
        $updateEntity['update_time'] = time();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}