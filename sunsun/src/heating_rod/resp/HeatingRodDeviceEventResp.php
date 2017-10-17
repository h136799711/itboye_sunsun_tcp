<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\resp;


use sunsun\heating_rod\req\HeatingRodDeviceEventReq;
use sunsun\po\BaseRespPo;

/**
 * Class HeatingRodHbReq
 * 设备事件响应
 * @package sunsun\heating_rod\req
 */
class HeatingRodDeviceEventResp extends BaseRespPo
{


    public function __construct(HeatingRodDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HeatingRodRespType::Event);
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