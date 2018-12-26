<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feederV2\resp;


use sunsun\feederV2\req\FeederV2DeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class FeederV2DeviceEventResp
 * 设备事件响应
 * @package sunsun\feederV2\req
 */
class FeederV2DeviceEventResp extends BaseDeviceEventServerResp
{

    public function __construct(FeederV2DeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederV2RespType::Event);
    }

}