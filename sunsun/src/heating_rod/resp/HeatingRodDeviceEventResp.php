<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\resp;


use sunsun\heating_rod\req\HeatingRodDeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class HeatingRodHbReq
 * 设备事件响应
 * @package sunsun\heating_rod\req
 */
class HeatingRodDeviceEventResp extends BaseDeviceEventServerResp
{
    public function __construct(HeatingRodDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HeatingRodRespType::Event);
    }
}