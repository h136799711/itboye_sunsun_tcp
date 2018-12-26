<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\resp;


use sunsun\feederV2\req\FeederV2HbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class FeederV2HbReq
 * 心跳包
 * @package sunsun\feederV2\req
 */
class FeederV2HbResp extends BaseHeartBeatServerResp
{
    public function __construct(FeederV2HbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederV2RespType::Heartbeat);
    }
}