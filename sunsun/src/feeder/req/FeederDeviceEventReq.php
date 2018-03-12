<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class FeederDeviceEventReq
 * 设备事件
 * @package sunsun\feeder\req
 */
class FeederDeviceEventReq extends BaseDeviceEventClientReq
{
    // 成员变量
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederReqType::Event);
    }
}