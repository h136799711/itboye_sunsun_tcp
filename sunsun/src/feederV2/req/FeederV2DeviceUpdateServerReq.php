<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\req;

use sunsun\server\req\BaseDeviceFirmwareUpdateServerReq;

/**
 * Class FeederV2DeviceUpdateReq
 * 设备更新请求
 * @package sunsun\feederV2\req
 */
class FeederV2DeviceUpdateServerReq extends BaseDeviceFirmwareUpdateServerReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederV2ReqType::FirmwareUpdate);
    }
}