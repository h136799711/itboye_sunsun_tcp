<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\req;

use sunsun\server\req\BaseDeviceFirmwareUpdateServerReq;

/**
 * Class WaterPumpHbReq
 * 设备更新请求
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceUpdateReq extends BaseDeviceFirmwareUpdateServerReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(WaterPumpReqType::FirmwareUpdate);
    }
}