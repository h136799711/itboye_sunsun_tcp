<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\req;

use sunsun\server\req\BaseControlDeviceServerReq;

/**
 * Class AdtHbReq
 * 设置设备
 * @package sunsun\adt\req
 */
class AdtCtrlDeviceReq extends BaseControlDeviceServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(AdtReqType::Control);
    }

    function toDataArray()
    {
        $data = [];

        $data['reqType'] = $this->getReqType();
        $data['sn'] = $this->getSn();

        if (!is_null($this->getDevLock())) {
            $data['devLock'] = $this->getDevLock();
        }
        if (!is_null($this->getMode())) {
            $data['mode'] = $this->getMode();
        }
        if (!is_null($this->getPer())) {
            if(is_array($this->getPer())){
                $data['per'] = json_encode($this->getPer());
            }else{
                $data['per'] = $this->getPer();
            }
        }

        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }
        if (!is_null($this->getR())) {
            $data['r'] = $this->getR();
        }
        if (!is_null($this->getG())) {
            $data['g'] = $this->getG();
        }
        if (!is_null($this->getB())) {
            $data['b'] = $this->getB();
        }
        if (!is_null($this->getW())) {
            $data['w'] = $this->getW();
        }
        if (!is_null($this->getSw())) {
            $data['sw'] = $this->getSw();
        }

        return $data;
    }

    private $pushCfg;
    private $devLock;
    private $mode;
    private $per;
    private $r;
    private $g;
    private $b;
    private $w;
    private $sw;

    /**
     * @return mixed
     */
    public function getR()
    {
        return $this->r;
    }

    /**
     * @param mixed $r
     */
    public function setR($r)
    {
        $this->r = $r;
    }

    /**
     * @return mixed
     */
    public function getG()
    {
        return $this->g;
    }

    /**
     * @param mixed $g
     */
    public function setG($g)
    {
        $this->g = $g;
    }

    /**
     * @return mixed
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * @param mixed $b
     */
    public function setB($b)
    {
        $this->b = $b;
    }

    /**
     * @return mixed
     */
    public function getW()
    {
        return $this->w;
    }

    /**
     * @param mixed $w
     */
    public function setW($w)
    {
        $this->w = $w;
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
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
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
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        array_key_exists("pushCfg", $data) && $this->setPushCfg($data['pushCfg']);
        array_key_exists("mode", $data) && $this->setMode($data['mode']);
        array_key_exists("per", $data) && $this->setPer($data['per']);
        array_key_exists("sw", $data) && $this->setSw($data['sw']);
        array_key_exists("r", $data) && $this->setSw($data['r']);
        array_key_exists("g", $data) && $this->setSw($data['g']);
        array_key_exists("b", $data) && $this->setSw($data['b']);
        array_key_exists("w", $data) && $this->setSw($data['w']);
    }

}