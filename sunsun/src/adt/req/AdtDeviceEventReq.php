<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class AdtDeviceEventReq
 * 设备事件
 * @package sunsun\adt\req
 */
class AdtDeviceEventReq extends BaseDeviceEventClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(AdtReqType::Event);
    }
}