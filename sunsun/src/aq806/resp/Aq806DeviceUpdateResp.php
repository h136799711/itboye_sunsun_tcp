<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\resp;


use sunsun\aq806\req\Aq806DeviceUpdateReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class Aq806HbReq
 * 心跳包
 * @package sunsun\aq806\req
 */
class Aq806DeviceUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(Aq806DeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq806RespType::FirmwareUpdate);
    }
}