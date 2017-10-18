<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\resp;


use sunsun\adt\req\AdtDeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class AdtHbReq
 * 设备事件响应
 * @package sunsun\adt\req
 */
class AdtDeviceEventResp extends BaseDeviceEventServerResp
{
    public function __construct(AdtDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(AdtRespType::Event);
    }
}