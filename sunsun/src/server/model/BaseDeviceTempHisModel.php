<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-18
 * Time: 10:15
 */

namespace sunsun\server\model;


use sunsun\model\BaseModel;

class BaseDeviceTempHisModel extends BaseModel
{
    private $did;
    private $temp;
    private $create_time;

    /**
     * @return mixed
     */
    public function getDid()
    {
        return $this->did;
    }

    /**
     * @param mixed $did
     */
    public function setDid($did)
    {
        $this->did = $did;
    }

    /**
     * @return mixed
     */
    public function getTemp()
    {
        return $this->temp;
    }

    /**
     * @param mixed $temp
     */
    public function setTemp($temp)
    {
        $this->temp = $temp;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @param mixed $create_time
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
    }

    public function toDataArray()
    {
        return [
            'did' => $this->getDid(),
            'create_time' => $this->getCreateTime(),
            'temp' => $this->getTemp(),
        ];
    }
}