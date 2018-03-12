<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\req;


use sunsun\server\req\BaseDeviceLoginClientReq;

/**
 * 设备登录请求
 * Class FeederLoginReq
 * @package sunsun\feeder\req
 */
class FeederLoginReq extends BaseDeviceLoginClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederReqType::Login);
    }
}