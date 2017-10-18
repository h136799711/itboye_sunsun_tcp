<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * Class Aph300HbReq
 * 获取设备状态
 * @package sunsun\aph300\req
 */
class Aph300DeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aph300ReqType::DeviceInfo);
    }

}