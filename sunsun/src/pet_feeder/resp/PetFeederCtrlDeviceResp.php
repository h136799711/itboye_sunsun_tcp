<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\resp;


use sunsun\pet_feeder\req\PetFeederCtrlDeviceReq;
use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseControlDeviceClientResp;

/**
 * ClassPetFeederHbReq
 * 设备状态响应包
 * @package sunsun\pet_feeder\req
 */
class PetFeederCtrlDeviceResp extends BaseControlDeviceClientResp implements ToDbEntityArrayInterface
{

    private $m;
    private $ws;
    private $fi;
    private $fp;
    private $fcd;
    private $fault;
    private $pushCfg;
    private $devLock;
    private $updState;
    private $fc;
    private $a;
    private $vol;

    /**
     * @return mixed
     */
    public function getVol()
    {
        return $this->vol;
    }

    /**
     * @param mixed $vol
     */
    public function setVol($vol)
    {
        $this->vol = $vol;
    }


    public function __construct(PetFeederCtrlDeviceReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(PetFeederRespType::Control);
        $this->setUpdState(-1);
    }

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

        if (!is_null($this->getFc())) {
            $data['fc'] = $this->getFc();
        }
        if (!is_null($this->getA())) {
            $data['a'] = $this->getA();
        }
        if (!is_null($this->getFault())) {
            $data['fault'] = $this->getFault();
        }
        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }
        if (!is_null($this->getFault())) {
            $data['fault'] = $this->getFault();
        }
        if (!is_null($this->getFp())) {
            $data['fp'] = $this->getFp();
            if (is_array($data['fp'])) {
                $data['fp'] = json_encode($data['fp']);
            }
        }
        if (!is_null($this->getFcd())) {
            $data['fcd'] = $this->getFcd();
        }
        if (!is_null($this->getFi())) {
            $data['fi'] = $this->getFi();
        }
        if (!is_null($this->getWs())) {
            $data['ws'] = $this->getWs();
        }
        if (!is_null($this->getM())) {
            $data['m'] = $this->getM();
        }

        if (!is_null($this->getVol())) {
            $data['vol'] = $this->getVol();
        }
        return $data;
    }

    /**
     * @return mixed
     */
    public function getFc()
    {
        return $this->fc;
    }

    /**
     * @param mixed $fc
     */
    public function setFc($fc)
    {
        $this->fc = $fc;
    }

    /**
     * @return mixed
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * @param mixed $a
     */
    public function setA($a)
    {
        $this->a = $a;
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
    public function getFp()
    {
        return $this->fp;
    }

    /**
     * @param mixed $fp
     */
    public function setFp($fp)
    {
        $this->fp = $fp;
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
    public function getFi()
    {
        return $this->fi;
    }

    /**
     * @param mixed $fi
     */
    public function setFi($fi)
    {
        $this->fi = $fi;
    }

    /**
     * @return mixed
     */
    public function getWs()
    {
        return $this->ws;
    }

    /**
     * @param mixed $ws
     */
    public function setWs($ws)
    {
        $this->ws = $ws;
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

    public function toDataArray()
    {

        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'devLock' => $this->getDevLock(),
            'push_cfg' => $this->getPushCfg(),
            'm' => $this->getM(),
            'fi' => $this->getFi(),
            'fp' => $this->getFp(),
            'ws' => $this->getWs(),
            'fcd' => $this->getFcd(),
            'fault' => $this->getFault(),
            'fc' => $this->getFc(),
            'a' => $this->getA(),
            'vol' => $this->getVol()
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
//        foreach ($this->toDataArray() as $key => $item) {
//            if (is_null($item)) {
//                return "缺少 " . $key . " 属性";
//            }
//        }
        return "";
    }
}