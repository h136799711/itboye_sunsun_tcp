<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\server\resp\BaseDeviceInfoClientResp;
use sunsun\water_pump\req\WaterPumpDeviceInfoReq;

/**
 * Class WaterPumpHbReq
 * 设备状态响应包
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceInfoResp extends BaseDeviceInfoClientResp
{

    public function __construct(WaterPumpDeviceInfoReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(WaterPumpRespType::DeviceInfo);
    }

    public function setData($data)
    {
        array_key_exists("sn", $data) && $this->setSn($data['sn']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        $this->setUpdState(-1);
        array_key_exists("updState", $data) && $this->setUpdState($data['updState']);
        array_key_exists("cfg", $data) && $this->setCfg($data['cfg']);
        array_key_exists("iCyc", $data) && $this->setICyc($data['iCyc']);
        array_key_exists("gear", $data) && $this->setGear($data['gear']);
        array_key_exists("pwr", $data) && $this->setPwr($data['pwr']);
        array_key_exists("spd", $data) && $this->setSpd($data['spd']);
        array_key_exists("type", $data) && $this->setType($data['type']);
        array_key_exists("state", $data) && $this->setState($data['state']);
        array_key_exists("fault", $data) && $this->setFault($data['fault']);
        array_key_exists("fcd", $data) && $this->setFcd($data['fcd']);
        array_key_exists("wh", $data) && $this->setWh($data['wh']);

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
            'wh'=>$this->getWh(),
            'fcd'=>$this->getFcd()
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