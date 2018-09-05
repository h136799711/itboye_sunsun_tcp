<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\resp;


use sunsun\pet_feeder\req\PetFeederDeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * ClassPetFeederDeviceEventResp
 * 设备事件响应
 * @package sunsun\pet_feeder\req
 */
class PetFeederDeviceEventResp extends BaseDeviceEventServerResp
{

    public function __construct(PetFeederDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(PetFeederRespType::Event);
    }

}