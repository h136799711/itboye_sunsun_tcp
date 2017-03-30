<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:53
 */

namespace sunsun\po;


abstract class BaseReqPo
{
    private $reqType;
    private $sn;

    /**
     * @return mixed
     */
    public function getReqType()
    {
        return $this->reqType;
    }

    /**
     * @param mixed $reqType
     */
    public function setReqType($reqType)
    {
        $this->reqType = $reqType;
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