<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aph300\action;


use sunsun\aph300\dal\Aph300DeviceDal;
use sunsun\aph300\helper\Aph300TcpLogHelper;
use sunsun\aph300\helper\ModelConverterHelper;
use sunsun\aph300\resp\Aph300CtrlDeviceResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class Aph300DeviceCtrlAction
{
    /**
     * 设备控制响应类似设备获取信息处理
     * 也是更新设备信息
     * @param $did
     * @param $clientId
     * @param Aph300CtrlDeviceResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, Aph300CtrlDeviceResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArrayOfCtrlDeviceResp($resp);
        $dal = new Aph300DeviceDal();
        Aph300TcpLogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity),"Aph300DeviceCtrlAction");
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

}