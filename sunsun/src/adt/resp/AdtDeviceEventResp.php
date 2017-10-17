<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\resp;


use sunsun\adt\req\AdtDeviceEventReq;
use sunsun\po\BaseRespPo;

/**
 * Class AdtHbReq
 * 设备事件响应
 * @package sunsun\adt\req
 */
class AdtDeviceEventResp extends BaseRespPo
{


    public function __construct(AdtDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(AdtRespType::Event);
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