<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\resp;


use sunsun\pet_feeder\req\PetFeederHbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * ClassPetFeederHbReq
 * 心跳包
 * @package sunsun\pet_feeder\req
 */
class PetFeederHbResp extends BaseHeartBeatServerResp
{
    public function __construct(PetFeederHbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(PetFeederRespType::Heartbeat);
    }
}