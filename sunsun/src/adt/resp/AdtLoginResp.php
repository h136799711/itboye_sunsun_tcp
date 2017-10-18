<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\resp;


use sunsun\adt\req\AdtLoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class AdtLoginResp extends BaseDeviceLoginServerResp
{
    public function __construct(AdtLoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(AdtRespType::Login);
    }
}