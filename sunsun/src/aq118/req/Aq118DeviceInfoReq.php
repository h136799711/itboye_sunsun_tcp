<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class Aq118HbReq
 * 获取设备状态
 * @package sunsun\aq118\req
 */
class Aq118DeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq118ReqType::DeviceInfo);
    }

}