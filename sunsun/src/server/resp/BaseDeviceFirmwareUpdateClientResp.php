<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-16
 * Time: 11:49
 */

namespace sunsun\server\resp;


use sunsun\po\BaseRespPo;

class BaseDeviceFirmwareUpdateClientResp extends BaseRespPo
{
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

    public function setData($data = null)
    {
        if (empty($data)) return;
        if (array_key_exists("sn", $data)) {
            $this->setSn($data['sn']);
        }

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
            'sn' => $this->getSn(),
            'state' => $this->getState()
        ];
    }


}