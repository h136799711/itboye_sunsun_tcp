<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\pet_feeder\action;

use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;
use sunsun\server\interfaces\BaseActionV2;
use sunsun\server\interfaces\BaseDalV2;
use sunsun\transfer_station\client\TransferClient;

class PetFeederDeviceInfoAction extends BaseActionV2
{
    public function deviceInfoUpdate($did, $clientId, BaseRespPo $resp, BaseDalV2 $dal)
    {
        if (!method_exists($resp, 'toDbEntityArray')) {
            throw new \Exception('resp toDbEntityArray method missing');
        }

        echo $did, " 设备信息".json_encode($resp->toDataArray()), "\n";

        // 更新设备信息
        $updateEntity = $resp->toDbEntityArray();
        $updateEntity['_client_id'] = $clientId;
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn());
        $ret = $dal->updateByDid($did, $resp->toDbEntityArray());
        return ResultHelper::success($ret);
    }
}