<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\resp;


use sunsun\cp1000\req\Cp1000DeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class Cp1000DeviceEventResp
 * 设备事件响应
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceEventResp extends BaseDeviceEventServerResp
{

    public function __construct(Cp1000DeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Cp1000RespType::Event);
    }

}