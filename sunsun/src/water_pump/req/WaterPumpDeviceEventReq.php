<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\req;

use sunsun\po\BaseReqPo;

/**
 * Class WaterPumpDeviceEventReq
 * 设备事件
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceEventReq extends BaseReqPo
{


    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            'pwr' => $this->getPwr(),
            'gear' => $this->getGear(),
            'spd'=>$this->getSpd()
        ];
    }



    public function __construct($data = null)
    {
        $this->setReqType(WaterPumpReqType::Event);
        if (!empty($data)) {
            $this->setSn($data['sn']);
            $this->setCode($data['code']);
            $this->setPwr(-1);
            $this->setGear(-1);
            $this->setSpd(-1);
            if (array_key_exists("pwr", $data)) {
                $this->setPwr($data['pwr']);
            }
            if (array_key_exists("gear", $data)) {
                $this->setGear($data['gear']);
            }
            if (array_key_exists("spd", $data)) {
                $this->setSpd($data['spd']);
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


    private $code;
    private $pwr;
    private $gear;
    private $spd;

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
    public function getPwr()
    {
        return $this->pwr;
    }

    /**
     * @param mixed $pwr
     */
    public function setPwr($pwr)
    {
        $this->pwr = $pwr;
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

    /**
     * @return mixed
     */
    public function getSpd()
    {
        return $this->spd;
    }

    /**
     * @param mixed $spd
     */
    public function setSpd($spd)
    {
        $this->spd = $spd;
    }


}