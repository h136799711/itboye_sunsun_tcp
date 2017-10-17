<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;


use sunsun\cp1000\dal\Cp1000DeviceDal;
use sunsun\cp1000\resp\Cp1000DeviceInfoResp;
use sunsun\server\interfaces\BaseAction;

class Cp1000DeviceInfoAction extends BaseAction
{
    public function updateInfo($did, $clientId, Cp1000DeviceInfoResp $resp)
    {
        return $this->updateDeviceInfo($did, $clientId, $resp, new Cp1000DeviceDal());
    }

}