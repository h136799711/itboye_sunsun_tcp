<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;


use sunsun\cp1000\dal\Cp1000DeviceDal;
use sunsun\cp1000\resp\Cp1000CtrlDeviceResp;
use sunsun\server\interfaces\BaseAction;

class Cp1000DeviceCtrlAction extends BaseAction
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
        return $this->deviceControlInfoUpdate($did, $clientId, $resp, new Cp1000DeviceDal());
    }

}