<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\resp;


use sunsun\cp1000\req\Cp1000CtrlDeviceReq;
use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseControlDeviceClientResp;

/**
 * Class Cp1000HbReq
 * 设备状态响应包
 * @package sunsun\cp1000\req
 */
class Cp1000CtrlDeviceResp extends BaseControlDeviceClientResp implements ToDbEntityArrayInterface
{

    public function __construct(Cp1000CtrlDeviceReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Cp1000RespType::Control);
        $this->setUpdState(-1);
    }

    public function toDbEntityArray()
    {
        $data = [];

        if (!is_null($this->getDevLock())) {
            $data['dev_lock'] = $this->getDevLock();
        }
        if (!is_null($this->getUpdState()) && $this->getUpdState() > -1) {
            $data['upd_state'] = $this->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }

        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }
        if (!is_null($this->getGear())) {
            $data['gear'] = $this->getGear();
        }

        if (!is_null($this->getMode())) {
            $data['mode'] = $this->getMode();
        }
        if (!is_null($this->getBLife())) {
            $data['b_life'] = $this->getBLife();
        }
        if (!is_null($this->getChCnt())) {
            $data['ch_cnt'] = $this->getChCnt();
        }
        if (!is_null($this->getState())) {
            $data['state'] = $this->getState();
        }
        if (!is_null($this->getWh())) {
            $data['wh'] = $this->getWh();
        }
        if (!is_null($this->getBatt())) {
            $data['batt'] = $this->getBatt();
        }
        if (!is_null($this->getRct())) {
            $data['rct'] = $this->getRct();
        }

        return $data;
    }


    public function toDataArray()
    {

        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'devLock' => $this->getDevLock(),
            'push_cfg' => $this->getPushCfg(),
            'gear' => $this->getGear(),
            'mode' => $this->getMode(),
            'b_life' => $this->getBLife(),
            'ch_cnt' => $this->getChCnt(),
            'state' => $this->getState(),
            'wh' => $this->getWh(),
            'batt' => $this->getBatt(),
            'rct' => $this->getRct()
        ];
        if ($this->getUpdState() == -1) {
            $data['updState'] = 0;
        } else {
            $data['updState'] = $this->getUpdState();
        }

        return $data;
    }


    public function check()
    {
        return "";
    }


    private $gear;
    private $state;
    private $mode;
    private $batt;
    private $rct;
    private $chCnt;
    private $bLife;
    private $wh;
    private $pushCfg;
    private $devLock;
    private $updState;

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
    public function getBatt()
    {
        return $this->batt;
    }

    /**
     * @param mixed $batt
     */
    public function setBatt($batt)
    {
        $this->batt = $batt;
    }

    /**
     * @return mixed
     */
    public function getRct()
    {
        return $this->rct;
    }

    /**
     * @param mixed $rct
     */
    public function setRct($rct)
    {
        $this->rct = $rct;
    }

    /**
     * @return mixed
     */
    public function getChCnt()
    {
        return $this->chCnt;
    }

    /**
     * @param mixed $chCnt
     */
    public function setChCnt($chCnt)
    {
        $this->chCnt = $chCnt;
    }

    /**
     * @return mixed
     */
    public function getBLife()
    {
        return $this->bLife;
    }

    /**
     * @param mixed $bLife
     */
    public function setBLife($bLife)
    {
        $this->bLife = $bLife;
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

    /**
     * @return mixed
     */
    public function getUpdState()
    {
        return $this->updState;
    }

    /**
     * @param mixed $updState
     */
    public function setUpdState($updState)
    {
        $this->updState = $updState;
    }

}