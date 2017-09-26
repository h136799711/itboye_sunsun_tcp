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
use sunsun\filter_vat\resp\FilterVatDeviceInfoResp;
use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\TransferClient;

class FilterVatDeviceInfoAction
{
    public function updateInfo($did, $clientId, FilterVatDeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new FilterVatDeviceDal();
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