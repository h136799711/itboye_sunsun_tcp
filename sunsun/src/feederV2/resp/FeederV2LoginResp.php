<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\resp;


use sunsun\feederV2\req\FeederV2LoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class FeederV2LoginResp extends BaseDeviceLoginServerResp
{
    public function __construct(FeederV2LoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederV2RespType::Login);
    }
}