<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\req;


use sunsun\server\req\BaseDeviceLoginClientReq;

/**
 * 设备登录请求
 * Class FeederV2LoginReq
 * @package sunsun\feederV2\req
 */
class FeederV2LoginReq extends BaseDeviceLoginClientReq
{
    private $type;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederV2ReqType::Login);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}