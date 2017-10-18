<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\server\resp\BaseDeviceEventServerResp;
use sunsun\water_pump\req\WaterPumpDeviceEventReq;

/**
 * Class WaterPumpHbReq
 * 设备事件响应
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceEventResp extends BaseDeviceEventServerResp
{
    public function __construct(WaterPumpDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(WaterPumpRespType::Event);
    }
}