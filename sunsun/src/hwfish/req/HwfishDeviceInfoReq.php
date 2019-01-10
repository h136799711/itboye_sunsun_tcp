<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class HwfishHbReq
 * 获取设备状态
 * @package sunsun\hwfish\req
 */
class HwfishDeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HwfishReqType::DeviceInfo);
    }

}