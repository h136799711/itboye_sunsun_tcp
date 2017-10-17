<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\resp;


use sunsun\aph300\req\Aph300DeviceUpdateReq;
use sunsun\po\BaseRespPo;

/**
 * Class Aph300HbReq
 * 心跳包
 * @package sunsun\aph300\req
 */
class Aph300DeviceUpdateResp extends BaseRespPo
{

    private $state;

    public function __construct(Aph300DeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aph300RespType::FirmwareUpdate);
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