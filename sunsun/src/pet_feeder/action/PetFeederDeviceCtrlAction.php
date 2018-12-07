<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\pet_feeder\action;


use sunsun\helper\ResultHelper;
use sunsun\server\interfaces\BaseActionV2;
use sunsun\server\interfaces\BaseDalV2;
use sunsun\server\resp\BaseControlDeviceClientResp;
use sunsun\transfer_station\client\TransferClient;
use sunsun\transfer_station\controller\RespMsgType;

class PetFeederDeviceCtrlAction extends BaseActionV2
{

    public function deviceControlInfoUpdate($did, $clientId, BaseControlDeviceClientResp $resp, BaseDalV2 $dal)
    {
        if (!method_exists($resp, 'toDbEntityArray')) {
            throw new \Exception('resp toDbEntityArray method missing');
        }

        echo $did, " 设备控制信息".json_encode($resp->toDataArray()), "\n";

        //更新设备信息
        $updateEntity = $resp->toDbEntityArray();
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn(), RespMsgType::DeviceControl);
        $updateEntity['update_time'] = time();
        if (method_exists($dal, 'updateByDid')) {
            $ret = $dal->updateByDid($did, $updateEntity);
            return ResultHelper::success($ret);
        } else {
            echo $did. " updateByDid method missing";
            return ResultHelper::fail('updateByDid method missing');
        }
    }

}