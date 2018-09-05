<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\resp;


use sunsun\pet_feeder\req\PetFeederDeviceUpdateServerReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * ClassPetFeederDeviceFirmwareUpdateResp
 * 固件更新响应包
 * @package sunsun\pet_feeder\resp
 */
class PetFeederDeviceFirmwareUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(PetFeederDeviceUpdateServerReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(PetFeederRespType::FirmwareUpdate);
    }
}