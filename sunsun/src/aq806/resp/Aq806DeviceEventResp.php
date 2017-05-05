<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\resp;


use sunsun\aq806\req\Aq806DeviceEventReq;
use sunsun\po\BaseRespPo;

/**
 * Class Aq806HbReq
 * 设备事件响应
 * @package sunsun\aq806\req
 */
class Aq806DeviceEventResp extends BaseRespPo
{


    public function __construct(Aq806DeviceEventReq $req = null)
    {
        $this->setRespType(Aq806RespType::Event);
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