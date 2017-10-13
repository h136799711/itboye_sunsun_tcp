<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\resp;


use sunsun\cp1000\req\Cp1000DeviceEventReq;
use sunsun\po\BaseRespPo;

/**
 * Class Cp1000HbReq
 * 设备事件响应
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceEventResp extends BaseRespPo
{


    public function __construct(Cp1000DeviceEventReq $req = null)
    {
        $this->setRespType(Cp1000RespType::Event);
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