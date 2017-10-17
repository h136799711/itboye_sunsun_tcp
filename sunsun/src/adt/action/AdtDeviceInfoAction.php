<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\adt\action;


use sunsun\adt\dal\AdtDeviceDal;
use sunsun\adt\helper\ModelConverterHelper;
use sunsun\adt\resp\AdtDeviceInfoResp;
use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\TransferClient;

class AdtDeviceInfoAction
{
    public function updateInfo($did, $clientId, AdtDeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new AdtDeviceDal();
        $avg = DevToServerDelayHelper::logRespTime($clientId,$resp);
        if($avg > 12345679.999){
            $avg = 12345679.999;
        }
        if($avg > 0) {
            $updateEntity['delay_avg'] = $avg;
        }
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity,$resp->getSn());
        $updateEntity['update_time'] = time();
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}