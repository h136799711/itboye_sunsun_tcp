<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\req;

use sunsun\server\req\BaseDeviceLoginClientReq;

class HwfishLoginReq extends BaseDeviceLoginClientReq
{

    private $type;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HwfishReqType::Login);
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