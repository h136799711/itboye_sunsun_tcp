<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\req;

use sunsun\server\req\BaseControlDeviceServerReq;

/**
 * Class HeatingRodHbReq
 * 设置设备
 * @package sunsun\heating_rod\req
 */
class HeatingRodCtrlDeviceReq extends BaseControlDeviceServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HeatingRodReqType::Control);
    }

    function toDataArray()
    {
        $data = [];

        $data['reqType'] = $this->getReqType();
        $data['sn'] = $this->getSn();

        if (!is_null($this->getDevLock())) {
            $data['devLock'] = $this->getDevLock();
        }
        if (!is_null($this->getCfg())) {
            $data['cfg'] = $this->getCfg();
        }
        if (!is_null($this->getTCyc())) {
            $data['tCyc'] = $this->getTCyc();
        }
        if (!is_null($this->getTSet())) {
            $data['tSet'] = $this->getTSet();
        }


        return $data;
    }

    private $tSet;
    private $tCyc;
    private $cfg;
    private $devLock;

    /**
     * @return mixed
     */
    public function getTSet()
    {
        return $this->tSet;
    }

    /**
     * @param mixed $tSet
     */
    public function setTSet($tSet)
    {
        $this->tSet = $tSet;
    }

    /**
     * @return mixed
     */
    public function getTCyc()
    {
        return $this->tCyc;
    }

    /**
     * @param mixed $tCyc
     */
    public function setTCyc($tCyc)
    {
        $this->tCyc = $tCyc;
    }

    /**
     * @return mixed
     */
    public function getCfg()
    {
        return $this->cfg;
    }

    /**
     * @param mixed $cfg
     */
    public function setCfg($cfg)
    {
        $this->cfg = $cfg;
    }


    /**
     * @return mixed
     */
    public function getDevLock()
    {
        return $this->devLock;
    }

    /**
     * @param mixed $devLock
     */
    public function setDevLock($devLock)
    {
        $this->devLock = $devLock;
    }

    public function setData($data = null)
    {
        array_key_exists("tSet", $data) && $this->setTSet($data['tSet']);
        array_key_exists("tCyc", $data) && $this->setTCyc($data['tCyc']);
        array_key_exists("cfg", $data) && $this->setCfg($data['cfg']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
    }


}