<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 20:05
 */

namespace sunsun\aq806\model;

use sunsun\server\model\BaseDeviceEventModel;

class Aq806DeviceEventModel extends BaseDeviceEventModel
{
    /**
     * @return array
     */
    public function toDataArray()
    {
        $hashId = 2;
        return [
            'did' => $this->getDid(),
            'event_type' => $this->getEventType(),
            'event_info' => $this->getEventInfo(),
            'create_time' => $this->getCreateTime(),
            'update_time' => $this->getUpdateTime(),
            'hash_id' =>  $hashId
        ];
    }
}