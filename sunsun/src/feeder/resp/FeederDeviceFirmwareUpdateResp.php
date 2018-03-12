<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\resp;


use sunsun\feeder\req\FeederDeviceUpdateServerReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class FeederDeviceFirmwareUpdateResp
 * 固件更新响应包
 * @package sunsun\feeder\resp
 */
class FeederDeviceFirmwareUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(FeederDeviceUpdateServerReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederRespType::FirmwareUpdate);
    }
}