<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\req;

use sunsun\po\BaseReqPo;

/**
 * Class Cp1000DeviceEventReq
 * 设备事件
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceEventReq extends BaseReqPo
{


    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            'mode' => $this->getMode(),
            'gear' => $this->getGear()
        ];
    }


    public function __construct($data = null)
    {
        $this->setReqType(Cp1000ReqType::Event);
        if (!empty($data)) {
            $this->setSn($data['sn']);
            $this->setCode($data['code']);
            $this->setMode(-1);
            $this->setGear(-1);
            if (array_key_exists("mode", $data)) {
                $this->setMode($data['mode']);
            }

            if (array_key_exists("gear", $data)) {
                $this->setGear($data['gear']);
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

    // 成员变量

    private $code;
    private $mode;
    private $gear;

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

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return mixed
     */
    public function getGear()
    {
        return $this->gear;
    }

    /**
     * @param mixed $gear
     */
    public function setGear($gear)
    {
        $this->gear = $gear;
    }


}