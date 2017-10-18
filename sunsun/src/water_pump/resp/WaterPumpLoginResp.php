<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;

use sunsun\server\resp\BaseDeviceLoginServerResp;
use sunsun\water_pump\req\WaterPumpLoginReq;

class WaterPumpLoginResp extends BaseDeviceLoginServerResp
{

    public function __construct(WaterPumpLoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(WaterPumpRespType::Login);
    }

}