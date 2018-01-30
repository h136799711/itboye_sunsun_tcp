<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\resp;


use sunsun\aq118\req\Aq118DeviceUpdateReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class Aq118HbReq
 * 心跳包
 * @package sunsun\aq118\req
 */
class Aq118DeviceUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(Aq118DeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq118RespType::FirmwareUpdate);
    }
}