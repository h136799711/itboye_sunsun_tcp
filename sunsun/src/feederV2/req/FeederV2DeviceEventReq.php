<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class FeederV2DeviceEventReq
 * 设备事件
 * @package sunsun\feederV2\req
 */
class FeederV2DeviceEventReq extends BaseDeviceEventClientReq
{
    // 成员变量
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederV2ReqType::Event);
    }
}