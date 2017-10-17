<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\resp;


use sunsun\aph300\req\Aph300DeviceEventReq;
use sunsun\po\BaseRespPo;

/**
 * Class Aph300HbReq
 * 设备事件响应
 * @package sunsun\aph300\req
 */
class Aph300DeviceEventResp extends BaseRespPo
{


    public function __construct(Aph300DeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aph300RespType::Event);
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