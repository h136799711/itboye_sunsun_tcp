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
use sunsun\heating_rod\resp\HeatingRodDeviceInfoResp;
use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\TransferClient;

class HeatingRodDeviceInfoAction
{
    public function updateInfo($did, $clientId, HeatingRodDeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new HeatingRodDeviceDal();
        $avg = DevToServerDelayHelper::logRespTime($clientId,$resp);
        if($avg > 12345679.999){
            $avg = 12345679.999;
        }
        if($avg > 0) {
            $updateEntity['delay_avg'] = $avg;
        }
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity,$resp->getSn());
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}