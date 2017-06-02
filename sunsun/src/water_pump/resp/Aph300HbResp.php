<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\water_pump\req\WaterPumpHbReq;
use sunsun\po\BaseRespPo;

/**
 * Class WaterPumpHbReq
 * 心跳包
 * @package sunsun\water_pump\req
 */
class WaterPumpHbResp extends BaseRespPo
{

    public function __construct(WaterPumpHbReq $req = null)
    {
        $this->setRespType(WaterPumpRespType::Heartbeat);
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn()
        ];
    }
}