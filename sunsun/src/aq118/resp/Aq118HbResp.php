<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\resp;


use sunsun\aq118\req\Aq118HbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class Aq118HbReq
 * 心跳包
 * @package sunsun\aq118\req
 */
class Aq118HbResp extends BaseHeartBeatServerResp
{
    public function __construct(Aq118HbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq118RespType::Heartbeat);
    }
}