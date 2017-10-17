<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\req;

use sunsun\po\BaseReqPo;

/**
 * Class Aph300DeviceEventReq
 * 设备事件
 * @package sunsun\aph300\req
 */
class Aph300DeviceEventReq extends BaseReqPo
{
    private $code;
    private $ph;
    private $t;


    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            'ph' => $this->getPh(),
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
    public function getPh()
    {
        return $this->ph;
    }

    /**
     * @param mixed $ph
     */
    public function setPh($ph)
    {
        $this->ph = $ph;
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
        $this->setReqType(Aph300ReqType::Event);
        if (!empty($data)) {
            $this->setCode($data['code']);
            $this->setT(-1);
            $this->setPh(-1);
            if (array_key_exists("t", $data)) {
                $this->setT($data['t']);
            }

            if (array_key_exists("ph", $data)) {
                $this->setPh($data['ph']);
            }

        }
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn()
        ];
    }


}