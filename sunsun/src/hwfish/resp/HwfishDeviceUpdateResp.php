<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\resp;


use sunsun\hwfish\req\HwfishDeviceUpdateReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class HwfishHbReq
 * 心跳包
 * @package sunsun\hwfish\req
 */
class HwfishDeviceUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(HwfishDeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HwfishRespType::FirmwareUpdate);
    }
}