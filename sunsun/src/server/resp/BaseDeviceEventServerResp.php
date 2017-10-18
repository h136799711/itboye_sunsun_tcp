<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-16
 * Time: 11:49
 */

namespace sunsun\server\resp;


use sunsun\po\BaseRespPo;

class BaseDeviceEventServerResp extends BaseRespPo
{

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'state' => $this->getState()
        ];
    }

    public function setData($data = null)
    {
        array_key_exists('sn', $data) && $this->setSn($data['sn']);
        array_key_exists('state', $data) && $this->setState($data['state']);
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

}