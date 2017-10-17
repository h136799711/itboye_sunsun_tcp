<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\server\resp\BaseHeartBeatServerResp;
use sunsun\water_pump\req\WaterPumpHbReq;

/**
 * Class WaterPumpHbReq
 * 心跳包
 * @package sunsun\water_pump\req
 */
class WaterPumpHbResp extends BaseHeartBeatServerResp
{
    public function __construct(WaterPumpHbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(WaterPumpRespType::Heartbeat);
    }
}