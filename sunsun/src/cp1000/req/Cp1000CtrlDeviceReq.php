<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\req;

use sunsun\po\BaseReqPo;

/**
 * Class Cp1000HbReq
 * 设置设备
 * @package sunsun\cp1000\req
 */
class Cp1000CtrlDeviceReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(Cp1000ReqType::Control);
        if (!empty($data)) {
            $this->setSn($data['sn']);
        }
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
        if (!is_null($this->getState())) {
            $data['state'] = $this->getState();
        }
        if (!is_null($this->getGear())) {
            $data['gear'] = $this->getGear();
        }
        if (!is_null($this->getMode())) {
            $data['mode'] = $this->getMode();
        }
        if (!is_null($this->getWh())) {
            $data['wh'] = $this->getWh();
        }
        if (!is_null($this->getChCnt())) {
            $data['ch_cnt'] = $this->getChCnt();
        }
        if (!is_null($this->getBLife())) {
            $data['b_life'] = $this->getBLife();
        }

        return $data;
    }

    public function setData($data)
    {
        array_key_exists("dev_lock", $data) && $this->setDevLock($data['dev_lock']);
        array_key_exists("push_cfg", $data) && $this->setPushCfg($data['push_cfg']);
        array_key_exists("state", $data) && $this->setState($data['state']);
        array_key_exists("gear", $data) && $this->setGear($data['gear']);
        array_key_exists("mode", $data) && $this->setMode($data['mode']);
        array_key_exists("wh", $data) && $this->setWh($data['wh']);
        array_key_exists("ch_cnt", $data) && $this->setChCnt($data['ch_cnt']);
        array_key_exists("b_life", $data) && $this->setBLife($data['b_life']);
    }

    private $devLock;
    private $state;
    private $gear;
    private $mode;
    private $wh;
    private $ch_cnt;
    private $b_life;
    private $push_cfg;

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

    /**
     * @return mixed
     */
    public function getGear()
    {
        return $this->gear;
    }

    /**
     * @param mixed $gear
     */
    public function setGear($gear)
    {
        $this->gear = $gear;
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
    public function getChCnt()
    {
        return $this->ch_cnt;
    }

    /**
     * @param mixed $ch_cnt
     */
    public function setChCnt($ch_cnt)
    {
        $this->ch_cnt = $ch_cnt;
    }

    /**
     * @return mixed
     */
    public function getBLife()
    {
        return $this->b_life;
    }

    /**
     * @param mixed $b_life
     */
    public function setBLife($b_life)
    {
        $this->b_life = $b_life;
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


}