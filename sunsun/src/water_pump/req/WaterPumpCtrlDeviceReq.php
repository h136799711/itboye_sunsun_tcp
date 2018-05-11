<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\req;

use sunsun\server\req\BaseControlDeviceServerReq;

/**
 * Class WaterPumpHbReq
 * 设置设备
 * @package sunsun\water_pump\req
 */
class WaterPumpCtrlDeviceReq extends BaseControlDeviceServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(WaterPumpReqType::Control);
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
        if (!is_null($this->getGear())) {
            $data['gear'] = $this->getGear();
        }
        if (!is_null($this->getICyc())) {
            $data['iCyc'] = $this->getICyc();
        }
        if (!is_null($this->getState())) {
            $data['state'] = $this->getState();
        }
        if (!is_null($this->getFcd())) {
            $data['fcd'] = $this->getFcd();
        }
        if (!is_null($this->getWh())) {
            $data['wh'] = $this->getWh();
        }
        if (!is_null($this->getWg())) {
            $data['wg'] = $this->getWg();
        }
        if (!is_null($this->getWc())) {
            $data['wc'] = $this->getWc();
        }
        if (!is_null($this->getWe())) {
            $data['we'] = $this->getWe();
        }
        // 新增 20180511
        if (!is_null($this->getM())) {
            $data['m'] = $this->getM();
        }
        if (!is_null($this->getPer())) {
            $data['per'] = $this->getPer();
        }

        return $data;
    }

    public function setData($data = null)
    {
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        array_key_exists("gear", $data) && $this->setGear($data['gear']);
        array_key_exists("iCyc", $data) && $this->setICyc($data['iCyc']);
        array_key_exists("cfg", $data) && $this->setCfg($data['cfg']);
        array_key_exists("state", $data) && $this->setState($data['state']);
        array_key_exists("fcd", $data) && $this->setFcd($data['fcd']);
        array_key_exists("wh", $data) && $this->setWh($data['wh']);
        array_key_exists("wg", $data) && $this->setWg($data['wg']);
        array_key_exists("we", $data) && $this->setWe($data['we']);
        array_key_exists("wc", $data) && $this->setWc($data['wc']);

        array_key_exists("m", $data) && $this->setM($data['m']);
        array_key_exists("per", $data) && $this->setPer($data['per']);

    }

    // 新增2个 20180511
    private $m;
    private $per;

    // 新增3个 造浪 2018-01-15
    private $wg;
    private $we;
    private $wc;

    private $devLock;
    private $gear;
    private $iCyc;
    private $cfg;
    private $state;
    private $fcd;
    private $wh;

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
    public function getWg()
    {
        return $this->wg;
    }

    /**
     * @param mixed $wg
     */
    public function setWg($wg)
    {
        $this->wg = $wg;
    }

    /**
     * @return mixed
     */
    public function getWe()
    {
        return $this->we;
    }

    /**
     * @param mixed $we
     */
    public function setWe($we)
    {
        $this->we = $we;
    }

    /**
     * @return mixed
     */
    public function getWc()
    {
        return $this->wc;
    }

    /**
     * @param mixed $wc
     */
    public function setWc($wc)
    {
        $this->wc = $wc;
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
    public function getFcd()
    {
        return $this->fcd;
    }

    /**
     * @param mixed $fcd
     */
    public function setFcd($fcd)
    {
        $this->fcd = $fcd;
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
    public function getICyc()
    {
        return $this->iCyc;
    }

    /**
     * @param mixed $iCyc
     */
    public function setICyc($iCyc)
    {
        $this->iCyc = $iCyc;
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

}