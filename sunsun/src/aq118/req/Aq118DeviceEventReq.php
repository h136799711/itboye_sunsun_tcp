<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class Aq118DeviceEventReq
 * 设备事件
 * @package sunsun\aq118\req
 */
class Aq118DeviceEventReq extends BaseDeviceEventClientReq
{
    private $ph;
    private $t;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq118ReqType::Event);
        if (!empty($data)) {
            $this->setT(-1);
            $this->setPh(-1);
            if (array_key_exists("t", $data)) {
                $this->setT($data['t']);
            }
            if (array_key_exists("ph", $data)) {
                $this->setPh($data['ph']);
            }

        }
    }

    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            'ph' => $this->getPh(),
            't' => $this->getT()
        ];
    }

    /**
     * @return mixed
     */
    public function getPh()
    {
        return $this->ph;
    }

    /**
     * @param mixed $ph
     */
    public function setPh($ph)
    {
        $this->ph = $ph;
    }

    /**
     * @return mixed
     */
    public function getT()
    {
        return $this->t;
    }

    /**
     * @param mixed $t
     */
    public function setT($t)
    {
        $this->t = $t;
    }

    function toDataArray()
    {
        return array_merge(parent::toDataArray(), [
            'ph' => $this->getPh(),
            't' => $this->getT()
        ]);
    }


}