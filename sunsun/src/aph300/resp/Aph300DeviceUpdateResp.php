<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\resp;


use sunsun\aph300\req\Aph300DeviceUpdateReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class Aph300HbReq
 * 心跳包
 * @package sunsun\aph300\req
 */
class Aph300DeviceUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(Aph300DeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aph300RespType::FirmwareUpdate);
    }
}