<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\resp;


use sunsun\water_pump\req\WaterPumpDeviceInfoReq;
use sunsun\po\BaseRespPo;

/**
 * Class WaterPumpHbReq
 * 设备状态响应包
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceInfoResp extends BaseRespPo
{


    public function __construct(WaterPumpDeviceInfoReq $req = null)
    {
        $this->setRespType(WaterPumpRespType::DeviceInfo);
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
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
            'devLock'=>$this->getDevLock()
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
        foreach ($this->toDataArray() as $key => $item) {
//            if (is_null($item)) {
//                return "缺少 " . $key . " 属性";
//            }
        }
        return "";
    }


    private $devLock;
    private $updState;
    private $spd;
    private $pwr;
    private $gear;
    private $iCyc;
    private $cfg;

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