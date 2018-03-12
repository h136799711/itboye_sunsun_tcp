<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseControlDeviceClientResp;
use sunsun\water_pump\req\WaterPumpCtrlDeviceReq;

/**
 * Class WaterPumpHbReq
 * 设备状态响应包
 * @package sunsun\water_pump\req
 */
class WaterPumpCtrlDeviceResp extends BaseControlDeviceClientResp implements ToDbEntityArrayInterface
{
    function toDbEntityArray()
    {
        $data = [];
        $data['update_time'] = time();
        if (!is_null($this->getDevLock())) {
            $data['dev_lock'] = $this->getDevLock();
        }
        if (!is_null($this->getUpdState()) && $this->getUpdState() > -1) {
            $data['upd_state'] = $this->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }

        if (!is_null($this->getWh())) {
            $data['wh'] = $this->getWh();
        }
        if (!is_null($this->getPwr())) {
            $data['pwr'] = $this->getPwr();
        }
        if (!is_null($this->getSpd())) {
            $data['spd'] = $this->getSpd();
        }
        if (!is_null($this->getGear())) {
            $data['gear'] = $this->getGear();
        }
        if (!is_null($this->getICyc())) {
            $data['i_cyc'] = $this->getICyc();
        }
        if (!is_null($this->getCfg())) {
            $data['cfg'] = $this->getCfg();
        }
        if (!empty($this->getType())) {
            $data['device_type'] = $this->getType();
        }
        if (!is_null($this->getState())) {
            $data['state'] = $this->getState();
        }
        if (!is_null($this->getFcd())) {
            $data['fcd'] = $this->getFcd();
        }
        if (!is_null($this->getFault())) {
            $data['fault'] = $this->getFault();
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

        return $data;
    }


    public function __construct(WaterPumpCtrlDeviceReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(WaterPumpRespType::Control);
        $this->setUpdState(-1);
    }

    public function toDataArray()
    {
        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'spd'=>$this->getSpd(),
            'pwr'=>$this->getPwr(),
            'gear'=>$this->getGear(),
            'iCyc'=>$this->getICyc(),
            'cfg'=>$this->getCfg(),
            'devLock'=>$this->getDevLock(),
            'type'=>$this->getType(),
            'state'=>$this->getState(),
            'fault'=>$this->getFault(),
            'fcd'=>$this->getFcd(),
            'wh' => $this->getWh(),
            'wg' => $this->getWg(),
            'wc' => $this->getWc(),
            'we' => $this->getWe()
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

    private $wg;
    private $we;
    private $wc;

    private $devLock;
    private $updState;
    private $spd;
    private $pwr;
    private $gear;
    private $iCyc;
    private $cfg;
    private $type;
    private $state;
    private $fault;
    private $fcd;
    private $wh;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
    public function getFault()
    {
        return $this->fault;
    }

    /**
     * @param mixed $fault
     */
    public function setFault($fault)
    {
        $this->fault = $fault;
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

    /**
     * @return mixed
     */
    public function getSpd()
    {
        return $this->spd;
    }

    /**
     * @param mixed $spd
     */
    public function setSpd($spd)
    {
        $this->spd = $spd;
    }

    /**
     * @return mixed
     */
    public function getPwr()
    {
        return $this->pwr;
    }

    /**
     * @param mixed $pwr
     */
    public function setPwr($pwr)
    {
        $this->pwr = $pwr;
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