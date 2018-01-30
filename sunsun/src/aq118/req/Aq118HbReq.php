<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\req;

use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * Class Aq118HbReq
 * 心跳包
 * @package sunsun\aq118\req
 */
class Aq118HbReq extends BaseHeartBeatClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq118ReqType::Heartbeat);
    }
}