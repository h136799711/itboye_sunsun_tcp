<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq136\resp;


use sunsun\aq136\req\Aq136DeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class Aq136HbReq
 * 设备事件响应
 * @package sunsun\aq136\req
 */
class Aq136DeviceEventResp extends BaseDeviceEventServerResp
{
    public function __construct(Aq136DeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq136RespType::Event);
    }
}