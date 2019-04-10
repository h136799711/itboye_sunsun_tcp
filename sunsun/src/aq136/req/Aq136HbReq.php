<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq136\req;

use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * Class Aq136HbReq
 * 心跳包
 * @package sunsun\aq136\req
 */
class Aq136HbReq extends BaseHeartBeatClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq136ReqType::Heartbeat);
    }
}