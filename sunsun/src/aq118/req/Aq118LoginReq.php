<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\req;

use sunsun\server\req\BaseDeviceLoginClientReq;

class Aq118LoginReq extends BaseDeviceLoginClientReq
{
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq118ReqType::Login);
    }


}