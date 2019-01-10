<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\resp;


use sunsun\hwfish\req\HwfishLoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class HwfishLoginResp extends BaseDeviceLoginServerResp
{

    public function __construct(HwfishLoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HwfishRespType::Login);
    }

}