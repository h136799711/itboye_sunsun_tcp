<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\resp;


use sunsun\aq118\req\Aq118LoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class Aq118LoginResp extends BaseDeviceLoginServerResp
{

    public function __construct(Aq118LoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq118RespType::Login);
    }

}