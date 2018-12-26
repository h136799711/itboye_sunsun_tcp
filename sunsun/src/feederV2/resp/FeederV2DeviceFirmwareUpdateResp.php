<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\resp;


use sunsun\feederV2\req\FeederV2DeviceUpdateServerReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class FeederV2DeviceFirmwareUpdateResp
 * 固件更新响应包
 * @package sunsun\feederV2\resp
 */
class FeederV2DeviceFirmwareUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(FeederV2DeviceUpdateServerReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederV2RespType::FirmwareUpdate);
    }
}