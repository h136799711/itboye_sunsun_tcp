<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class AdtHbReq
 * 获取设备状态
 * @package sunsun\adt\req
 */
class AdtDeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(AdtReqType::DeviceInfo);
    }

}