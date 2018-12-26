<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class FeederV2DeviceInfoReq
 * 获取设备信息
 * @package sunsun\feederV2\req
 */
class FeederV2DeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederV2ReqType::DeviceInfo);
    }

}