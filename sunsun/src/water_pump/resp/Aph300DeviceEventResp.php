<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\water_pump\req\WaterPumpDeviceEventReq;
use sunsun\po\BaseRespPo;

/**
 * Class WaterPumpHbReq
 * 设备事件响应
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceEventResp extends BaseRespPo
{


    public function __construct(WaterPumpDeviceEventReq $req = null)
    {
        $this->setRespType(WaterPumpRespType::Event);
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
    }

    private $state;

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'state' => $this->getState()
        ];
    }

}