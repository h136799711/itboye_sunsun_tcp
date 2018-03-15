<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\req;

use sunsun\server\req\BaseDeviceLoginClientReq;

class WaterPumpLoginReq extends BaseDeviceLoginClientReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(WaterPumpReqType::Login);
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
            'did' => $this->getDid(),
            'ver' => $this->getVer(),
            'pwd' => $this->getPwd(),
        ];
    }


}