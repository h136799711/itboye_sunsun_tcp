<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq136\resp;


use sunsun\aq136\req\Aq136LoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class Aq136LoginResp extends BaseDeviceLoginServerResp
{

    public function __construct(Aq136LoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq136RespType::Login);
    }

}