<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\resp;


use sunsun\aq806\req\Aq806DeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class Aq806HbReq
 * 设备事件响应
 * @package sunsun\aq806\req
 */
class Aq806DeviceEventResp extends BaseDeviceEventServerResp
{
    public function __construct(Aq806DeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq806RespType::Event);
    }
}