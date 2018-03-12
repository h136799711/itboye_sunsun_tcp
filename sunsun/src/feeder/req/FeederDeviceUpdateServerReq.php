<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\req;

use sunsun\server\req\BaseDeviceFirmwareUpdateServerReq;

/**
 * Class FeederDeviceUpdateReq
 * 设备更新请求
 * @package sunsun\feeder\req
 */
class FeederDeviceUpdateServerReq extends BaseDeviceFirmwareUpdateServerReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederReqType::FirmwareUpdate);
    }
}