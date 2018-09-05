<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\req;

use sunsun\server\req\BaseDeviceInfoServerReq;

/**
 * ClassPetFeederDeviceInfoReq
 * 获取设备信息
 * @package sunsun\pet_feeder\req
 */
class PetFeederDeviceInfoReq extends BaseDeviceInfoServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(PetFeederReqType::DeviceInfo);
    }

}