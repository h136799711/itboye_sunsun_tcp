<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq136\resp;


use sunsun\aq136\req\Aq136HbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class Aq136HbReq
 * 心跳包
 * @package sunsun\aq136\req
 */
class Aq136HbResp extends BaseHeartBeatServerResp
{
    public function __construct(Aq136HbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq136RespType::Heartbeat);
    }
}