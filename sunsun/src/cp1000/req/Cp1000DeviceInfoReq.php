<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class Cp1000DeviceInfoReq
 * 获取设备信息
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Cp1000ReqType::DeviceInfo);
    }

}