<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\req;

use sunsun\server\req\BaseDeviceFirmwareUpdateServerReq;

/**
 * Class AdtHbReq
 * 设备更新请求
 * @package sunsun\adt\req
 */
class AdtDeviceUpdateReq extends BaseDeviceFirmwareUpdateServerReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(AdtReqType::FirmwareUpdate);
    }
}