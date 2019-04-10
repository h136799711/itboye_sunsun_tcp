<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq136\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class Aq136HbReq
 * 获取设备状态
 * @package sunsun\aq136\req
 */
class Aq136DeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq136ReqType::DeviceInfo);
    }

}