<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\resp;


use sunsun\heating_rod\req\HeatingRodDeviceUpdateReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class HeatingRodHbReq
 * 心跳包
 * @package sunsun\heating_rod\req
 */
class HeatingRodDeviceUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(HeatingRodDeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HeatingRodRespType::FirmwareUpdate);
    }
}