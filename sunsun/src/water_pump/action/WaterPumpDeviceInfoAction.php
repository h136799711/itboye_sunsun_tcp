<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\water_pump\action;


use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\TransferClient;
use sunsun\water_pump\dal\WaterPumpDeviceDal;
use sunsun\water_pump\helper\ModelConverterHelper;
use sunsun\water_pump\helper\WaterPumpTcpLogHelper;
use sunsun\water_pump\resp\WaterPumpDeviceInfoResp;

class WaterPumpDeviceInfoAction
{
    public function updateInfo($did, $clientId, WaterPumpDeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            WaterPumpTcpLogHelper::logDebug($did, 'WaterPumpDeviceInfoAction_updateInfo_'.$check);
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new WaterPumpDeviceDal();
        $avg = DevToServerDelayHelper::logRespTime($clientId,$resp);
        if($avg > 12345679.999){
            $avg = 12345679.999;
        }
        if($avg > 0) {
            $updateEntity['delay_avg'] = $avg;
        }
        WaterPumpTcpLogHelper::logDebug($did, 'updateEntity' . json_encode($updateEntity));

        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity,$resp->getSn());
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}