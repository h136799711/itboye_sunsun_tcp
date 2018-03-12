<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\resp;

use sunsun\feeder\req\FeederDeviceInfoReq;
use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseDeviceInfoClientResp;

/**
 * Class FeederDeviceInfoResp
 * 设备状态响应包
 * @package sunsun\feeder\resp
 */
class FeederDeviceInfoResp extends BaseDeviceInfoClientResp implements ToDbEntityArrayInterface
{

    private $pushCfg;
    private $updState;
    private $devLock;
    private $m;
    private $fc;
    private $fp;
    private $fi;
    private $ws;
    private $fault;


    public function __construct(FeederDeviceInfoReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FeederRespType::DeviceInfo);
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

        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }
        if (!is_null($this->getFault())) {
            $data['fault'] = $this->getFault();
        }
        if (!is_null($this->getFp())) {
            $data['fp'] = $this->getFp();
        }
        if (!is_null($this->getFc())) {
            $data['fc'] = $this->getFc();
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


        return $data;
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
            'fc' => $this->getFc(),
            'fault' => $this->getFault()
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
}