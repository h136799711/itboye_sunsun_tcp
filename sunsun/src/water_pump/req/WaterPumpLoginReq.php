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
        if (!empty($data)) {
            if(array_key_exists('type',$data)){
                $this->setType($data['type']);
            }
        }
    }

    private $type;

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