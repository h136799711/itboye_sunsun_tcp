<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 20:05
 */

namespace sunsun\heating_rod\model;


use sunsun\model\BaseModel;

class HeatingRodDeviceEventModel extends BaseModel
{
    private $did;
    private $updateTime;
    private $eventType;
    private $eventInfo;

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
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param mixed $updateTime
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @return mixed
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param mixed $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * @return mixed
     */
    public function getEventInfo()
    {
        return $this->eventInfo;
    }

    /**
     * @param mixed $eventInfo
     */
    public function setEventInfo($eventInfo)
    {
        $this->eventInfo = $eventInfo;
    }



    public function toDataArray(){
        return [
            'did'=>$this->getDid(),
            'event_type'=>$this->getEventType(),
            'event_info'=>$this->getEventInfo(),
            'create_time'=>$this->getCreateTime(),
            'update_time'=>$this->getUpdateTime()
        ];
    }

}