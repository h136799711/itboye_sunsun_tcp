<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\resp;


use sunsun\aq806\req\Aq806LoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class Aq806LoginResp extends BaseDeviceLoginServerResp
{

    public function __construct(Aq806LoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq806RespType::Login);
    }

}