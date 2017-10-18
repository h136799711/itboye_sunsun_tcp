<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\req;

use sunsun\server\req\BaseDeviceFirmwareUpdateServerReq;

/**
 * Class Aq806HbReq
 * 设备更新请求
 * @package sunsun\aq806\req
 */
class Aq806DeviceUpdateReq extends BaseDeviceFirmwareUpdateServerReq
{


    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq806ReqType::FirmwareUpdate);
    }

}