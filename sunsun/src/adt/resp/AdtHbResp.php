<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\resp;


use sunsun\adt\req\AdtHbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class AdtHbReq
 * 心跳包
 * @package sunsun\adt\req
 */
class AdtHbResp extends BaseHeartBeatServerResp
{

    public function __construct(AdtHbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(AdtRespType::Heartbeat);
    }
}