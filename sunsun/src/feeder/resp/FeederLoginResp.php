<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\resp;


use sunsun\feeder\req\FeederLoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class FeederLoginResp extends BaseDeviceLoginServerResp
{
    public function __construct(FeederLoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederRespType::Login);
    }
}