<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\resp;


use sunsun\aph300\req\Aph300DeviceInfoReq;
use sunsun\po\BaseRespPo;

/**
 * Class Aph300HbReq
 * 设备状态响应包
 * @package sunsun\aph300\req
 */
class Aph300DeviceInfoResp extends BaseRespPo
{

    //t	1	int		实时温度	温度值的10倍值
    private $t;
    //ph	1	int		实时PH值	数值为实际PH值的100倍
    private $ph;
    //th	1	int		水温异常高温阈值	温度值的10倍值
    private $th;
    //tl	1	int		水温异常低温阈值	温度值的10倍值
    private $tl;
    private $phh;
    private $phl;
    private $dCyc;
    private $fault;
    private $pushCfg;
    private $phCmd;
    private $phSche;
    private $phDly;
    private $devLock;
    private $updState;

    public function __construct(Aph300DeviceInfoReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aph300RespType::DeviceInfo);
    }

    /**
     * 设备传输过来的数据转换成该类
     * @param $data
     */
    public function setData($data)
    {
        array_key_exists("sn", $data) && $this->setSn($data['sn']);
        array_key_exists("t", $data) && $this->setT($data['t']);
        array_key_exists("ph", $data) && $this->setPh($data['ph']);
        array_key_exists("th", $data) && $this->setTh($data['th']);
        array_key_exists("tl", $data) && $this->setTl($data['tl']);
        array_key_exists("phh", $data) && $this->setPhh($data['phh']);
        array_key_exists("phl", $data) && $this->setPhl($data['phl']);

        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        $this->setUpdState(-1);
        array_key_exists("updState", $data) && $this->setUpdState($data['updState']);

        array_key_exists("push_cfg", $data) && $this->setPushCfg($data['push_cfg']);
        array_key_exists("d_cyc", $data) && $this->setDCyc($data['d_cyc']);
        array_key_exists("fault", $data) && $this->setFault($data['fault']);
        array_key_exists("ph_dly", $data) && $this->setPhDly($data['ph_dly']);
        array_key_exists("ph_sche", $data) && $this->setPhSche($data['ph_sche']);
        array_key_exists("ph_cmd", $data) && $this->setPhCmd($data['ph_cmd']);
    }

    public function toDataArray()
    {
        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            't' => $this->getT(),
            'ph' => $this->getPh(),
            'th' => $this->getTh(),
            'tl' => $this->getTl(),
            'phh' => $this->getPhh(),
            'phl' => $this->getPhl(),
            'fault' => $this->getFault(),
            'devLock' => $this->getDevLock(),
            'push_cfg' => $this->getPushCfg(),
            'd_cyc' => $this->getDCyc(),
            'ph_cmd'=>$this->getPhCmd(),
            'ph_sche'=>$this->getPhSche(),
            'ph_dly'=>$this->getPhDly()
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
    public function getPh()
    {
        return $this->ph;
    }

    /**
     * @param mixed $ph
     */
    public function setPh($ph)
    {
        $this->ph = $ph;
    }

    /**
     * @return mixed
     */
    public function getTh()
    {
        return $this->th;
    }

    /**
     * @param mixed $th
     */
    public function setTh($th)
    {
        $this->th = $th;
    }

    /**
     * @return mixed
     */
    public function getTl()
    {
        return $this->tl;
    }

    /**
     * @param mixed $tl
     */
    public function setTl($tl)
    {
        $this->tl = $tl;
    }

    /**
     * @return mixed
     */
    public function getPhh()
    {
        return $this->phh;
    }

    /**
     * @param mixed $phh
     */
    public function setPhh($phh)
    {
        $this->phh = $phh;
    }

    /**
     * @return mixed
     */
    public function getPhl()
    {
        return $this->phl;
    }

    /**
     * @param mixed $phl
     */
    public function setPhl($phl)
    {
        $this->phl = $phl;
    }

    /**
     * @return mixed
     */
    public function getDCyc()
    {
        return $this->dCyc;
    }

    /**
     * @param mixed $dCyc
     */
    public function setDCyc($dCyc)
    {
        $this->dCyc = $dCyc;
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
    public function getPhCmd()
    {
        return $this->phCmd;
    }

    /**
     * @param mixed $phCmd
     */
    public function setPhCmd($phCmd)
    {
        $this->phCmd = $phCmd;
    }

    /**
     * @return mixed
     */
    public function getPhSche()
    {
        return $this->phSche;
    }

    /**
     * @param mixed $phSche
     */
    public function setPhSche($phSche)
    {
        $this->phSche = $phSche;
    }

    /**
     * @return mixed
     */
    public function getPhDly()
    {
        return $this->phDly;
    }

    /**
     * @param mixed $phDly
     */
    public function setPhDly($phDly)
    {
        $this->phDly = $phDly;
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
////            if (is_null($item)) {
////                return  $key . " is null value";
////            }
//        }
        return "";
    }

}