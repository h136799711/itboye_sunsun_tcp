<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\req;


use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * Class FeederHbReq
 * 心跳包
 * @package sunsun\feeder\req
 */
class FeederHbReq extends BaseHeartBeatClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederReqType::Heartbeat);
    }
}