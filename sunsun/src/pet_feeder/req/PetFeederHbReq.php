<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\req;


use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * ClassPetFeederHbReq
 * 心跳包
 * @package sunsun\pet_feeder\req
 */
class PetFeederHbReq extends BaseHeartBeatClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(PetFeederReqType::Heartbeat);
    }
}