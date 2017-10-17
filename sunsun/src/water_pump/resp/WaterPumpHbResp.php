<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\po\BaseRespPo;
use sunsun\water_pump\req\WaterPumpHbReq;

/**
 * Class WaterPumpHbReq
 * 心跳包
 * @package sunsun\water_pump\req
 */
class WaterPumpHbResp extends BaseRespPo
{

    public function __construct(WaterPumpHbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(WaterPumpRespType::Heartbeat);
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn()
        ];
    }
}