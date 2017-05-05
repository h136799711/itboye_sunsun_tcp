<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:16
 */

namespace sunsun\po;


class TdsPo
{
    private $tdsData;
    private $tdsOriginData;
    private $tdsType;
    private $tdsValid;


    /**
     * @return mixed
     */
    public function getTdsData()
    {
        return $this->tdsData;
    }

    /**
     * @param mixed $tdsData
     */
    public function setTdsData($tdsData)
    {
        $this->tdsData = $tdsData;
    }

    /**
     * @return mixed
     */
    public function getTdsOriginData()
    {
        return $this->tdsOriginData;
    }

    /**
     * @param mixed $tdsOriginData
     */
    public function setTdsOriginData($tdsOriginData)
    {
        $this->tdsOriginData = $tdsOriginData;
    }

    /**
     * @return mixed
     */
    public function getTdsType()
    {
        return $this->tdsType;
    }

    /**
     * @param mixed $tdsType
     */
    public function setTdsType($tdsType)
    {
        $this->tdsType = $tdsType;
    }

    /**
     * @return mixed
     */
    public function getTdsValid()
    {
        return $this->tdsValid;
    }

    /**
     * @param mixed $tdsValid
     */
    public function setTdsValid($tdsValid)
    {
        $this->tdsValid = $tdsValid;
    }

    public function isValid()
    {
        return $this->tdsValid == 1;
    }

}