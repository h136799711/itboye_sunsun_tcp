<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\resp;


use sunsun\cp1000\req\Cp1000DeviceUpdateReq;
use sunsun\po\BaseRespPo;

/**
 * Class Cp1000HbReq
 * 心跳包
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceUpdateResp extends BaseRespPo
{

    private $state;

    public function __construct(Cp1000DeviceUpdateReq $req = null)
    {
        $this->setRespType(Cp1000RespType::FirmwareUpdate);
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
    }

    public function setData($data)
    {

        if (array_key_exists("state", $data)) {
            $this->setState($data['state']);
        } else {
            //默认999
            $this->setState(999);
        }
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn()
        ];
    }

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


}