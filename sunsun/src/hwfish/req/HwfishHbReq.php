<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\req;

use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * Class HwfishHbReq
 * 心跳包
 * @package sunsun\hwfish\req
 */
class HwfishHbReq extends BaseHeartBeatClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HwfishReqType::Heartbeat);
    }
}