<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * ClassPetFeederDeviceEventReq
 * 设备事件
 * @package sunsun\pet_feeder\req
 */
class PetFeederDeviceEventReq extends BaseDeviceEventClientReq
{
    // 成员变量
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(PetFeederReqType::Event);
    }
}