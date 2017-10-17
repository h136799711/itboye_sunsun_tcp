<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\resp;


use sunsun\cp1000\req\Cp1000DeviceUpdateServerReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class Cp1000DeviceFirmwareUpdateResp
 * 固件更新响应包
 * @package sunsun\cp1000\resp
 */
class Cp1000DeviceFirmwareUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(Cp1000DeviceUpdateServerReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Cp1000RespType::FirmwareUpdate);
    }
}