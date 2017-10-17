<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\resp;


use sunsun\heating_rod\req\HeatingRodHbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class HeatingRodHbReq
 * 心跳包
 * @package sunsun\heating_rod\req
 */
class HeatingRodHbResp extends BaseHeartBeatServerResp
{
    public function __construct(HeatingRodHbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HeatingRodRespType::Heartbeat);
    }
}