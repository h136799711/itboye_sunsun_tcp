<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\req;

use sunsun\server\req\BaseControlDeviceServerReq;

/**
 * Class HwfishHbReq
 * 设置设备
 * @package sunsun\hwfish\req
 */
class HwfishCtrlDeviceReq extends BaseControlDeviceServerReq
{

    private $devLock;
    private $sw;
    private $per;
    private $m;
    private $wh;
    private $th;
    private $tl;
    private $dCyc;
    private $pushCfg;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HwfishReqType::Control);
    }

    function toDataArray()
    {
        $data = [];

        $data['reqType'] = $this->getReqType();
        $data['sn'] = $this->getSn();
        if (!is_null($this->getDevLock())) {
            $data['devLock'] = $this->getDevLock();
        }

        if (!is_null($this->getSw())) {
            $data['sw'] = $this->getSw();
        }
        if (!is_null($this->getWh())) {
            $data['wh'] = $this->getWh();
        }

        if (!is_null($this->getM())) {
            $data['m'] = $this->getM();
        }
        if (!is_null($this->getTh())) {
            $data['th'] = $this->getTh();
        }
        if (!is_null($this->getTl())) {
            $data['tl'] = $this->getTl();
        }
        if (!is_null($this->getPer())) {
            $data['l_per'] = $this->getPer();
        }

        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }
        if (!is_null($this->getDCyc())) {
            $data['d_cyc'] = $this->getDCyc();
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
    public function getSw()
    {
        return $this->sw;
    }

    /**
     * @param mixed $sw
     */
    public function setSw($sw)
    {
        $this->sw = $sw;
    }

    /**
     * @return mixed
     */
    public function getWh()
    {
        return $this->wh;
    }

    /**
     * @param mixed $wh
     */
    public function setWh($wh)
    {
        $this->wh = $wh;
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
    public function getTh()
    {
        return $this->th;
    }

    /**
     * @param mixed $th
     */
    public function setTh($th)
    {
        $this->th = $th;
    }

    /**
     * @return mixed
     */
    public function getTl()
    {
        return $this->tl;
    }

    /**
     * @param mixed $tl
     */
    public function setTl($tl)
    {
        $this->tl = $tl;
    }

    /**
     * @return mixed
     */
    public function getPer()
    {
        return $this->per;
    }

    /**
     * @param mixed $per
     */
    public function setPer($per)
    {
        $this->per = $per;
    }

    /**
     * @return mixed
     */
    public function getPushCfg()
    {
        return $this->pushCfg;
    }

    /**
     * @param mixed $pushCfg
     */
    public function setPushCfg($pushCfg)
    {
        $this->pushCfg = $pushCfg;
    }

    /**
     * @return mixed
     */
    public function getDCyc()
    {
        return $this->dCyc;
    }

    /**
     * @param mixed $dCyc
     */
    public function setDCyc($dCyc)
    {
        $this->dCyc = $dCyc;
    }

    public function setData($data = null)
    {
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        array_key_exists("pushCfg", $data) && $this->setPushCfg($data['pushCfg']);
        array_key_exists("m", $data) && $this->setM($data['m']);
        array_key_exists("dCyc", $data) && $this->setDCyc($data['dCyc']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        array_key_exists("per", $data) && $this->setPer($data['per']);
        array_key_exists("sw", $data) && $this->setSw($data['sw']);
        array_key_exists("wh", $data) && $this->setWh($data['wh']);
    }


}