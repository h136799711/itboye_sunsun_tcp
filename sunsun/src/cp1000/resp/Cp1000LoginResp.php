<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\resp;


use sunsun\cp1000\req\Cp1000LoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class Cp1000LoginResp extends BaseDeviceLoginServerResp
{
    public function __construct(Cp1000LoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Cp1000RespType::Login);
    }
}