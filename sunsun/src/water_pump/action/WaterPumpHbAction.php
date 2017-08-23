<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\water_pump\action;


use sunsun\water_pump\dal\WaterPumpDeviceDal;
use sunsun\water_pump\req\WaterPumpHbReq;
use sunsun\water_pump\resp\WaterPumpHbResp;

/**
 * Class WaterPumpHbAction
 * 心跳包处理
 * @package sunsun\water_pump\action
 */
class WaterPumpHbAction
{
    public function heartBeat($did, $clientId, WaterPumpHbReq $req)
    {
        (new WaterPumpDeviceDal())->updateByDid()
        return new WaterPumpHbResp($req);
    }
}