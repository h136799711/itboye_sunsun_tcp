<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\resp;


use sunsun\feeder\req\FeederDeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class FeederDeviceEventResp
 * 设备事件响应
 * @package sunsun\feeder\req
 */
class FeederDeviceEventResp extends BaseDeviceEventServerResp
{

    public function __construct(FeederDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederRespType::Event);
    }

}