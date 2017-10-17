<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\resp;


use sunsun\cp1000\req\Cp1000HbReq;
use sunsun\server\resp\BaseHeartBeatServerResp;

/**
 * Class Cp1000HbReq
 * 心跳包
 * @package sunsun\cp1000\req
 */
class Cp1000HbResp extends BaseHeartBeatServerResp
{
    public function __construct(Cp1000HbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Cp1000RespType::Heartbeat);
    }
}