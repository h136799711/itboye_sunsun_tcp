<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class HeatingRodHbReq
 * 获取设备状态
 * @package sunsun\heating_rod\req
 */
class HeatingRodDeviceInfoReq extends BaseDeviceInfoServerReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HeatingRodReqType::DeviceInfo);
    }
}