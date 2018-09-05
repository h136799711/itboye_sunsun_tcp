<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\resp;


use sunsun\pet_feeder\req\PetFeederLoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class PetFeederLoginResp extends BaseDeviceLoginServerResp
{
    public function __construct(PetFeederLoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(PetFeederRespType::Login);
    }
}