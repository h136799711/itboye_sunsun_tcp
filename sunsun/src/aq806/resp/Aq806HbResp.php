<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\resp;


use sunsun\aq806\req\Aq806HbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class Aq806HbReq
 * 心跳包
 * @package sunsun\aq806\req
 */
class Aq806HbResp extends BaseHeartBeatServerResp
{
    public function __construct(Aq806HbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq806RespType::Heartbeat);
    }
}