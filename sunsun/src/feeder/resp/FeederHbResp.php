<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\resp;


use sunsun\feeder\req\FeederHbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class FeederHbReq
 * 心跳包
 * @package sunsun\feeder\req
 */
class FeederHbResp extends BaseHeartBeatServerResp
{
    public function __construct(FeederHbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederRespType::Heartbeat);
    }
}