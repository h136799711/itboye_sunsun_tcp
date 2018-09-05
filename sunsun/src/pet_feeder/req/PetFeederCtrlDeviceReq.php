<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\req;

use sunsun\server\req\BaseControlDeviceServerReq;

/**
 * ClassPetFeederCtrlDeviceReq
 * 设置设备
 * @package sunsun\pet_feeder\req
 */
class PetFeederCtrlDeviceReq extends BaseControlDeviceServerReq
{

    private $devLock;
    private $push_cfg;
    private $m;
    private $ws;
    private $fp;
    private $url;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(PetFeederReqType::Control);
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

        if (!is_null($this->getFp())) {
            $data['fp'] = $this->getFp();
        }
        if (!is_null($this->getM())) {
            $data['m'] = $this->getM();
        }

        if (!is_null($this->getWs())) {
            $data['ws'] = $this->getWs();
        }

        if (!empty($this->getUrl())) {
            $data['url'] = $this->getUrl();
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
        $this->devLock = $devLock;
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
        $this->push_cfg = $push_cfg;
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
        $this->m = $m;
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
        $this->ws = $ws;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setData($data = null)
    {
        array_key_exists("dev_lock", $data) && $this->setDevLock($data['dev_lock']);
        array_key_exists("push_cfg", $data) && $this->setPushCfg($data['push_cfg']);
        array_key_exists("m", $data) && $this->setM($data['m']);
        array_key_exists("url", $data) && $this->setUrl($data['url']);
        array_key_exists("fp", $data) && $this->setFp($data['fp']);
        array_key_exists("ws", $data) && $this->setWs($data['ws']);
    }
}