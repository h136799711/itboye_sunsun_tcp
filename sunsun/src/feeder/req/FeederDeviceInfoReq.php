<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class FeederDeviceInfoReq
 * 获取设备信息
 * @package sunsun\feeder\req
 */
class FeederDeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederReqType::DeviceInfo);
    }

}