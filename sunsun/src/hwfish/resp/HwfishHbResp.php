<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\resp;


use sunsun\hwfish\req\HwfishHbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class HwfishHbReq
 * 心跳包
 * @package sunsun\hwfish\req
 */
class HwfishHbResp extends BaseHeartBeatServerResp
{
    public function __construct(HwfishHbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HwfishRespType::Heartbeat);
    }
}