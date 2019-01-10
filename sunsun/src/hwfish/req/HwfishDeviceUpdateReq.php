<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\req;

use sunsun\server\req\BaseDeviceFirmwareUpdateServerReq;

/**
 * Class HwfishHbReq
 * 设备更新请求
 * @package sunsun\hwfish\req
 */
class HwfishDeviceUpdateReq extends BaseDeviceFirmwareUpdateServerReq
{


    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HwfishReqType::FirmwareUpdate);
    }

}