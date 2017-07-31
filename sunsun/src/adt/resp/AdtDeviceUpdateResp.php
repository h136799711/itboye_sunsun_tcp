<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\resp;


use sunsun\adt\req\AdtDeviceUpdateReq;
use sunsun\po\BaseRespPo;

/**
 * Class AdtHbReq
 * 心跳包
 * @package sunsun\adt\req
 */
class AdtDeviceUpdateResp extends BaseRespPo
{

    private $state;

    public function __construct(AdtDeviceUpdateReq $req = null)
    {
        $this->setRespType(AdtRespType::FirmwareUpdate);
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