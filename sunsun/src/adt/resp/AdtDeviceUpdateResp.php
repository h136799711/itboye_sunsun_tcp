<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\resp;


use sunsun\adt\req\AdtDeviceUpdateReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class AdtHbReq
 * 心跳包
 * @package sunsun\adt\req
 */
class AdtDeviceUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(AdtDeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(AdtRespType::FirmwareUpdate);
    }
}