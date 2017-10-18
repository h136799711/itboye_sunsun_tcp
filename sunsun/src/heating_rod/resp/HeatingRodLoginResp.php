<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\resp;


use sunsun\heating_rod\req\HeatingRodLoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class HeatingRodLoginResp extends BaseDeviceLoginServerResp
{
    public function __construct(HeatingRodLoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HeatingRodRespType::Login);
    }
}