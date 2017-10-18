<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\req;

use sunsun\server\req\BaseDeviceFirmwareUpdateServerReq;

/**
 * Class Aph300HbReq
 * 设备更新请求
 * @package sunsun\aph300\req
 */
class Aph300DeviceUpdateReq extends BaseDeviceFirmwareUpdateServerReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aph300ReqType::FirmwareUpdate);
    }
}