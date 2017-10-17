<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\req;

use sunsun\server\req\BaseDeviceFirmwareUpdateServerReq;

/**
 * Class Cp1000DeviceUpdateReq
 * 设备更新请求
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceUpdateServerReq extends BaseDeviceFirmwareUpdateServerReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Cp1000ReqType::FirmwareUpdate);
    }
}