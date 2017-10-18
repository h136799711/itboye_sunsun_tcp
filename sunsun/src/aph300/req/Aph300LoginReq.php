<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\req;

use sunsun\server\req\BaseDeviceLoginClientReq;

class Aph300LoginReq extends BaseDeviceLoginClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aph300ReqType::Login);
    }

}