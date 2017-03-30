<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:53
 */

namespace sunsun\po;


abstract class BaseRespPo
{
    private $respType;
    private $sn;

    /**
     * @return mixed
     */
    public function getRespType()
    {
        return $this->respType;
    }

    /**
     * @param mixed $respType
     */
    public function setRespType($respType)
    {
        $this->respType = $respType;
    }


    /**
     * @return mixed
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * @param mixed $sn
     */
    public function setSn($sn)
    {
        $this->sn = $sn;
    }

    abstract function toDataArray();

}