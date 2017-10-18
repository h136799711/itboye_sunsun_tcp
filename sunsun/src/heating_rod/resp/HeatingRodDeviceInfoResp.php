<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\resp;


use sunsun\heating_rod\req\HeatingRodDeviceInfoReq;
use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseDeviceInfoClientResp;

/**
 * Class HeatingRodHbReq
 * 设备状态响应包
 * @package sunsun\heating_rod\req
 */
class HeatingRodDeviceInfoResp extends BaseDeviceInfoClientResp implements ToDbEntityArrayInterface
{
    public function toDbEntityArray()
    {
        $data = [];
        $data['update_time'] = time();
        if (!is_null($this->getT())) {
            $data['t'] = $this->getT();
        }
        if (!is_null($this->getPwr())) {
            $data['pwr'] = $this->getPwr();
        }
        if (!is_null($this->getTSet())) {
            $data['t_set'] = $this->getTSet();
        }
        if (!is_null($this->getTCyc())) {
            $data['t_cyc'] = $this->getTCyc();
        }
        if (!is_null($this->getCfg())) {
            $data['cfg'] = $this->getCfg();
        }

        if (!is_null($this->getDevLock())) {
            $data['dev_lock'] = $this->getDevLock();
        }
        if (!is_null($this->getUpdState()) && $this->getUpdState() > -1) {
            $data['upd_state'] = $this->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }

        return $data;
    }

    public function __construct(HeatingRodDeviceInfoReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(HeatingRodRespType::DeviceInfo);
    }

    public function setData($data = null)
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
            'devLock' => $this->getDevLock()
        ];
        if ($this->getUpdState() == -1) {
            $data['updState'] = 0;
        } else {
            $data['updState'] = $this->getUpdState();
        }

        return $data;
    }

    private $t;
    private $pwr;
    private $tSet;
    private $tCyc;
    private $cfg;
    private $devLock;
    /**
     * 固件更新状态
     * 0 -100：更新进度百分比，更新成功为100
     * 101：更新失败，硬件重启后该字段隐藏
     */
    private $updState;


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
     * 实时功率    功率值，单位瓦特
     * @return mixed
     */
    public function getPwr()
    {
        return $this->pwr;
    }

    /**
     * 实时功率    功率值，单位瓦特
     * @param mixed $pwr
     */
    public function setPwr($pwr)
    {
        $this->pwr = $pwr;
    }

    /**
     * 温度的十倍值
     * @return mixed
     */
    public function getTSet()
    {
        return $this->tSet;
    }

    /**
     * 温度的十倍值
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