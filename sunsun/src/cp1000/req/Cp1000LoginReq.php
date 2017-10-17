<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\req;


use sunsun\server\req\BaseDeviceLoginClientReq;

/**
 * 设备登录请求
 * Class Cp1000LoginReq
 * @package sunsun\cp1000\req
 */
class Cp1000LoginReq extends BaseDeviceLoginClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Cp1000ReqType::Login);
    }
}