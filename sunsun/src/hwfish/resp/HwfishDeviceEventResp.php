<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\resp;


use sunsun\hwfish\req\HwfishDeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class HwfishHbReq
 * 设备事件响应
 * @package sunsun\hwfish\req
 */
class HwfishDeviceEventResp extends BaseDeviceEventServerResp
{
    public function __construct(HwfishDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HwfishRespType::Event);
    }
}