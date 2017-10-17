<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\req;

use sunsun\po\BaseReqPo;

/**
 * Class HeatingRodHbReq
 * 设备事件
 * @package sunsun\heating_rod\req
 */
class HeatingRodDeviceEventReq extends BaseReqPo
{
    private $code;
    private $t;

    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            't' => $this->getT()
        ];
    }


    /**
     * @return mixed
     */
    public function getT()
    {
        return $this->t;
    }

    /**
     * @param mixed $t
     */
    public function setT($t)
    {
        $this->t = $t;
    }


    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HeatingRodReqType::Event);
        if (!empty($data)) {
            $this->setCode($data['code']);
            $this->setT($data['t']);
        }
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),

        ];
    }


}