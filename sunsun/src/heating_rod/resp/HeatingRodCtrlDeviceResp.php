<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\resp;


use sunsun\heating_rod\req\HeatingRodCtrlDeviceReq;
use sunsun\po\BaseRespPo;

/**
 * Class HeatingRodHbReq
 * 设备状态响应包
 * @package sunsun\heating_rod\req
 */
class HeatingRodCtrlDeviceResp extends BaseRespPo
{

    private $t;
    private $pwr;
    private $tSet;
    private $tCyc;
    private $cfg;

    /**
     * 设备锁机状态
     * 0：未锁机，可局域网查找
     * 1：锁机，局域网隐藏
     * @var
     */
    private $devLock;
    /**
     * 固件更新状态
     * 0 -100：更新进度百分比，更新成功为100
     * 101：更新失败，硬件重启后该字段隐藏
     */
    private $updState;


    public function __construct(HeatingRodCtrlDeviceReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HeatingRodRespType::Control);
    }

    public function setData($data)
    {
        array_key_exists("sn", $data) && $this->setSn($data['sn']);
        array_key_exists("t", $data) && $this->setT($data['t']);
        array_key_exists("pwr", $data) && $this->setPwr($data['pwr']);
        array_key_exists("tSet", $data) && $this->setTSet($data['tSet']);
        array_key_exists("tCyc", $data) && $this->setTCyc($data['tCyc']);
        array_key_exists("cfg", $data) && $this->setCfg($data['cfg']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        $this->setUpdState(-1);
        array_key_exists("updState", $data) && $this->setUpdState($data['updState']);
    }

    public function toDataArray()
    {

        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            't' => $this->getT(),
            'pwr' => $this->getPwr(),
            'tSet' => $this->getTSet(),
            'tCyc' => $this->getTCyc(),
            'cfg' => $this->getCfg(),
            'devLock' => $this->getDevLock(),
        ];
        if ($this->getUpdState() == -1) {
            $data['updState'] = 0;
        } else {
            $data['updState'] = $this->getUpdState();
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function getT()
    {
        return $this->t;
    }

    /**
     * @param mixed $t
     */
    public function setT($t)
    {
        $this->t = $t;
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
    public function getTSet()
    {
        return $this->tSet;
    }

    /**
     * @param mixed $tSet
     */
    public function setTSet($tSet)
    {
        $this->tSet = $tSet;
    }

    /**
     * @return mixed
     */
    public function getTCyc()
    {
        return $this->tCyc;
    }

    /**
     * @param mixed $tCyc
     */
    public function setTCyc($tCyc)
    {
        $this->tCyc = $tCyc;
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

    public function check()
    {
//        foreach ($this->toDataArray() as $key => $item) {
//            if (is_null($item)) {
//                return "缺少 " . $key . " 属性";
//            }
//        }
        return "";
    }

}