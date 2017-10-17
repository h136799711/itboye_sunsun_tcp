<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\po\BaseRespPo;
use sunsun\water_pump\req\WaterPumpDeviceUpdateReq;

/**
 * Class WaterPumpHbReq
 * 心跳包
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceUpdateResp extends BaseRespPo
{

    private $state;

    public function __construct(WaterPumpDeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(WaterPumpRespType::FirmwareUpdate);
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