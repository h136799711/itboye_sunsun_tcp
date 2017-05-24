<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\req;

use sunsun\po\BaseReqPo;

/**
 * Class Aph300HbReq
 * 设置设备
 * @package sunsun\aph300\req
 */
class Aph300CtrlDeviceReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(Aph300ReqType::Control);
        if (!empty($data)) {
            $this->setSn($data['sn']);
        }
    }

    function toDataArray()
    {
        $data = [];

        $data['reqType'] = $this->getReqType();
        $data['sn'] = $this->getSn();

        if (!is_null($this->getDevLock())) {
            $data['devLock'] = $this->getDevLock();
        }

        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }
        if (!is_null($this->getDCyc())) {
            $data['d_cyc'] = $this->getDCyc();
        }

        return $data;
    }

    private $tmL;
    private $mode;
    private $outUvc;
    private $outSp;
    private $outL;
    private $tMax;
    private $th;
    private $tl;
    private $lPer;
    private $uvcPer;
    private $spPer;
    private $pushCfg;
    private $devLock;
    private $dCyc;
    private $uvWh;
    private $pWh;
    private $lWh;

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
    public function getUvWh()
    {
        return $this->uvWh;
    }

    /**
     * @param mixed $uvWh
     */
    public function setUvWh($uvWh)
    {
        $this->uvWh = $uvWh;
    }

    /**
     * @return mixed
     */
    public function getPWh()
    {
        return $this->pWh;
    }

    /**
     * @param mixed $pWh
     */
    public function setPWh($pWh)
    {
        $this->pWh = $pWh;
    }

    /**
     * @return mixed
     */
    public function getLWh()
    {
        return $this->lWh;
    }

    /**
     * @param mixed $lWh
     */
    public function setLWh($lWh)
    {
        $this->lWh = $lWh;
    }


    /**
     * @return mixed
     */
    public function getTmL()
    {
        return $this->tmL;
    }

    /**
     * @param mixed $tmL
     */
    public function setTmL($tmL)
    {
        $this->tmL = $tmL;
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
    public function getOutUvc()
    {
        return $this->outUvc;
    }

    /**
     * @param mixed $outUvc
     */
    public function setOutUvc($outUvc)
    {
        $this->outUvc = $outUvc;
    }

    /**
     * @return mixed
     */
    public function getOutSp()
    {
        return $this->outSp;
    }

    /**
     * @param mixed $outSp
     */
    public function setOutSp($outSp)
    {
        $this->outSp = $outSp;
    }

    /**
     * @return mixed
     */
    public function getOutL()
    {
        return $this->outL;
    }

    /**
     * @param mixed $outL
     */
    public function setOutL($outL)
    {
        $this->outL = $outL;
    }

    /**
     * @return mixed
     */
    public function getTMax()
    {
        return $this->tMax;
    }

    /**
     * @param mixed $tMax
     */
    public function setTMax($tMax)
    {
        $this->tMax = $tMax;
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
    public function getLPer()
    {
        return $this->lPer;
    }

    /**
     * @param mixed $lPer
     */
    public function setLPer($lPer)
    {
        $this->lPer = $lPer;
    }

    /**
     * @return mixed
     */
    public function getUvcPer()
    {
        return $this->uvcPer;
    }

    /**
     * @param mixed $uvcPer
     */
    public function setUvcPer($uvcPer)
    {
        $this->uvcPer = $uvcPer;
    }

    /**
     * @return mixed
     */
    public function getSpPer()
    {
        return $this->spPer;
    }

    /**
     * @param mixed $spPer
     */
    public function setSpPer($spPer)
    {
        $this->spPer = $spPer;
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

    public function setData($data)
    {
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        array_key_exists("pushCfg", $data) && $this->setPushCfg($data['pushCfg']);
        array_key_exists("spPer", $data) && $this->setSpPer($data['spPer']);
        array_key_exists("uvcPer", $data) && $this->setUvcPer($data['uvcPer']);
        array_key_exists("lPer", $data) && $this->setLPer($data['lPer']);
        array_key_exists("tl", $data) && $this->setTl($data['tl']);
        array_key_exists("th", $data) && $this->setTh($data['th']);
        array_key_exists("tMax", $data) && $this->setTMax($data['tMax']);

        array_key_exists("outL", $data) && $this->setOutL($data['outL']);

        array_key_exists("outSp", $data) && $this->setOutSp($data['outSp']);
        array_key_exists("outUvc", $data) && $this->setOutUvc($data['outUvc']);
        array_key_exists("mode", $data) && $this->setMode($data['mode']);

        array_key_exists("tmL", $data) && $this->setTmL($data['tmL']);

        array_key_exists("dCyc", $data) && $this->setDCyc($data['dCyc']);
        array_key_exists("uvWh", $data) && $this->setUvWh($data['uvWh']);
        array_key_exists("pWh", $data) && $this->setPWh($data['pWh']);
        array_key_exists("lWh", $data) && $this->setLWh($data['lWh']);


    }


}