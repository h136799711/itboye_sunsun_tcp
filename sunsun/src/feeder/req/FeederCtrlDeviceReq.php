<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\req;

use sunsun\server\req\BaseControlDeviceServerReq;

/**
 * Class FeederCtrlDeviceReq
 * 设置设备
 * @package sunsun\feeder\req
 */
class FeederCtrlDeviceReq extends BaseControlDeviceServerReq
{

    private $devLock;
    private $push_cfg;
    private $m;
    private $fc;
    private $ws;
    private $fp;


    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FeederReqType::Control);
    }

    function toDataArray()
    {
        $data = [];

        $data['reqType'] = $this->getReqType();
        $data['sn'] = $this->getSn();

        if (!is_null($this->getDevLock())) {
            $data['devLock'] = $this->getDevLock();
        }

        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }
        if (!is_null($this->getFc())) {
            $data['fc'] = $this->getFc();
        }
        if (!is_null($this->getFp())) {
            $data['fp'] = $this->getFp();
        }
        if (!is_null($this->getM())) {
            $data['m'] = $this->getM();
        }
        if (!is_null($this->getWs())) {
            $data['ws'] = $this->getWs();
        }

        return $data;
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
        $this->devLock = intval($devLock);
    }

    /**
     * @return mixed
     */
    public function getPushCfg()
    {
        return $this->push_cfg;
    }

    /**
     * @param mixed $push_cfg
     */
    public function setPushCfg($push_cfg)
    {
        $this->push_cfg = intval($push_cfg);
    }

    /**
     * @return mixed
     */
    public function getFc()
    {
        return $this->fc;
    }

    /**
     * @param mixed $fc
     */
    public function setFc($fc)
    {
        $this->fc = intval($fc);
    }

    /**
     * @return mixed
     */
    public function getFp()
    {
        return $this->fp;
    }

    /**
     * @param mixed $fp
     */
    public function setFp($fp)
    {
        $this->fp = $fp;
    }

    /**
     * @return mixed
     */
    public function getM()
    {
        return $this->m;
    }

    /**
     * @param mixed $m
     */
    public function setM($m)
    {
        $this->m = intval($m);
    }

    /**
     * @return mixed
     */
    public function getWs()
    {
        return $this->ws;
    }

    /**
     * @param mixed $ws
     */
    public function setWs($ws)
    {
        $this->ws = intval($ws);
    }

    public function setData($data = null)
    {
        array_key_exists("dev_lock", $data) && $this->setDevLock($data['dev_lock']);
        array_key_exists("push_cfg", $data) && $this->setPushCfg($data['push_cfg']);
        array_key_exists("m", $data) && $this->setM($data['m']);
        array_key_exists("fc", $data) && $this->setFc($data['fc']);
        array_key_exists("fp", $data) && $this->setFp($data['fp']);
        array_key_exists("ws", $data) && $this->setWs($data['ws']);
    }
}