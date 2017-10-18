<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class Aq806DeviceEventReq
 * 设备事件
 * @package sunsun\aq806\req
 */
class Aq806DeviceEventReq extends BaseDeviceEventClientReq
{
    private $ph;
    private $t;
    private $dyn;


    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            'ph' => $this->getPh(),
            't' => $this->getT(),
            'dyn' => $this->getDyn()
        ];
    }

    /**
     * @return mixed
     */
    public function getDyn()
    {
        return $this->dyn;
    }

    /**
     * @param mixed $dyn
     */
    public function setDyn($dyn)
    {
        $this->dyn = $dyn;
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

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq806ReqType::Event);
        if (!empty($data)) {
            $this->setT(-1);
            $this->setDyn(-1);
            $this->setPh(-1);
            if (array_key_exists("t", $data)) {
                $this->setT($data['t']);
            }

            if (array_key_exists("dyn", $data)) {
                $this->setDyn($data['dyn']);
            }

            if (array_key_exists("ph", $data)) {
                $this->setPh($data['ph']);
            }

        }
    }

    function toDataArray()
    {
        return array_merge(parent::toDataArray(), [
            'ph' => $this->getPh(),
            'dyn' => $this->getDyn(),
            't' => $this->getT()
        ]);
    }


}