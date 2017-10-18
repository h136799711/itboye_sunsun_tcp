<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\resp;


use sunsun\po\BaseReqPo;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class Aph300LoginResp extends BaseDeviceLoginServerResp
{
    public function __construct(BaseReqPo $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aph300RespType::Login);
    }
}