<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\req;


use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * Class FeederV2HbReq
 * 心跳包
 * @package sunsun\feederV2\req
 */
class FeederV2HbReq extends BaseHeartBeatClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederV2ReqType::Heartbeat);
    }
}