<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\resp;


use sunsun\aph300\req\Aph300HbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class Aph300HbReq
 * 心跳包
 * @package sunsun\aph300\req
 */
class Aph300HbResp extends BaseHeartBeatServerResp
{
    public function __construct(Aph300HbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aph300RespType::Heartbeat);
    }
}