<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\resp;


use sunsun\aq118\req\Aq118DeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class Aq118HbReq
 * 设备事件响应
 * @package sunsun\aq118\req
 */
class Aq118DeviceEventResp extends BaseDeviceEventServerResp
{
    public function __construct(Aq118DeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq118RespType::Event);
    }
}