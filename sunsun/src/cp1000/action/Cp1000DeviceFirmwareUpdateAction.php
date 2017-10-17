<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;

use sunsun\cp1000\resp\Cp1000DeviceFirmwareUpdateResp;
use sunsun\server\interfaces\BaseAction;

class Cp1000DeviceFirmwareUpdateAction extends BaseAction
{
    /**
     * 设备固件更新响应处理
     * @param $did
     * @param $clientId
     * @param Cp1000DeviceFirmwareUpdateResp $resp
     * @return array
     */
    public function updateInfo($did, $clientId, Cp1000DeviceFirmwareUpdateResp $resp)
    {
        return $this->firmUpdate($did, $clientId, $resp);
    }

}