<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-18
 * Time: 10:14
 */

namespace sunsun\server\model;


use sunsun\model\BaseModel;

class BaseDeviceEventModel extends BaseModel
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

    public function toDataArray()
    {
        $data = [
            'did' => $this->getDid(),
            'event_type' => $this->getEventType(),
            'event_info' => $this->getEventInfo(),
            'create_time' => $this->getCreateTime(),
            'update_time' => $this->getUpdateTime(),
        ];
        if (strpos($this->getDid(), 'S03') === 0) {
            $data['hash_id'] = (int) rand(1, 5);
        }

        return $data;
    }
}