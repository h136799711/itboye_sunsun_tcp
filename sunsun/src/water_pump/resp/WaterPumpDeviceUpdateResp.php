<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;
use sunsun\water_pump\req\WaterPumpDeviceUpdateReq;

/**
 * Class WaterPumpHbReq
 * 心跳包
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(WaterPumpDeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(WaterPumpRespType::FirmwareUpdate);
    }
}