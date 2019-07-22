<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\req;

use sunsun\server\req\BaseControlDeviceServerReq;

/**
 * Class Aq806HbReq
 * 设置设备
 * @package sunsun\aq806\req
 */
class Aq806CtrlDeviceReq extends BaseControlDeviceServerReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq806ReqType::Control);
    }

    function toDataArray()
    {
        $data = [];

        $data['reqType'] = $this->getReqType();
        $data['sn'] = $this->getSn();
        if (!is_null($this->getDevLock())) {
            $data['devLock'] = $this->getDevLock();
        }

        if (!is_null($this->getTmL())) {
            $data['tm_l'] = "".$this->getTmL();
        }

        if (!is_null($this->getMode())) {
            $data['mode'] = $this->getMode();
        }
        if (!is_null($this->getOutUvc())) {
            $data['out_uvc'] = $this->getOutUvc();
        }
        if (!is_null($this->getOutSp())) {
            $data['out_sp'] = $this->getOutSp();
        }
        if (!is_null($this->getOutL())) {
            $data['out_l'] = $this->getOutL();
        }
        if (!is_null($this->getTMax())) {
            $data['tMax'] = $this->getTMax();
        }
        if (!is_null($this->getTh())) {
            $data['th'] = $this->getTh();
        }
        if (!is_null($this->getTl())) {
            $data['tl'] = $this->getTl();
        }
        if (!is_null($this->getLPer())) {
            $data['l_per'] = $this->getLPer();
        }
        if (!is_null($this->getE1Per())) {
            $data['e1_per'] = $this->getE1Per();
        }
        if (!is_null($this->getE2Per())) {
            $data['e2_per'] = $this->getE2Per();
        }
        if (!is_null($this->getUvcPer())) {
            $data['uvc_per'] = $this->getUvcPer();
        }
        if (!is_null($this->getSpPer())) {
            $data['sp_per'] = $this->getSpPer();
        }
        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }
        if (!is_null($this->getDCyc())) {
            $data['d_cyc'] = $this->getDCyc();
        }
        if (!is_null($this->getUvWh())) {
            $data['uv_wh'] = $this->getUvWh();
        }
        if (!is_null($this->getPWh())) {
            $data['p_wh'] = $this->getPWh();
        }
        if (!is_null($this->getLWh())) {
            $data['l_wh'] = $this->getLWh();
        }
        if (!is_null($this->getPhCmd())) {
            $data['ph_cmd'] = $this->getPhCmd();
        }

        if (!is_null($this->getE1Dly())) {
            $data['e1_dly'] = $this->getE1Dly();
        }
        if (!is_null($this->getE2Dly())) {
            $data['e2_dly'] = $this->getE2Dly();
        }
        if (!is_null($this->getE1M())) {
            $data['e1_m'] = $this->getE1M();
        }
        if (!is_null($this->getE2M())) {
            $data['e2_m'] = $this->getE2M();
        }
        if (!is_null($this->getE1S())) {
            $data['e1_s'] = $this->getE1S();
        }
        if (!is_null($this->getE2S())) {
            $data['e2_s'] = $this->getE2S();
        }

        return $data;
    }

    /**
     * PH校准命令
     * @var
     * @add 2017-07-14 新增属性
     */
    private $ph_cmd;
    private $tmL;
    private $mode;
    private $outUvc;
    private $outSp;
    private $outL;
    private $tMax;
    private $th;
    private $tl;
    private $lPer;
    private $e2Per;
    private $e1Per;
    private $uvcPer;
    private $spPer;
    private $pushCfg;
    private $devLock;
    private $dCyc;
    private $uvWh;
    private $pWh;
    private $lWh;
    private $e1Dly;
    private $e1M;
    private $e2M;
    private $e2Dly;
    protected $e1S;
    protected $e2S;

    /**
     * @return mixed
     */
    public function getE1S()
    {
        return $this->e1S;
    }

    /**
     * @param mixed $e1S
     */
    public function setE1S($e1S)
    {
        $this->e1S = $e1S;
    }

    /**
     * @return mixed
     */
    public function getE2S()
    {
        return $this->e2S;
    }

    /**
     * @param mixed $e2S
     */
    public function setE2S($e2S)
    {
        $this->e2S = $e2S;
    }

    /**
     * @return mixed
     */
    public function getE1Dly()
    {
        return $this->e1Dly;
    }

    /**
     * @param mixed $e1Dly
     */
    public function setE1Dly($e1Dly)
    {
        $this->e1Dly = $e1Dly;
    }

    /**
     * @return mixed
     */
    public function getE1M()
    {
        return $this->e1M;
    }

    /**
     * @param mixed $e1M
     */
    public function setE1M($e1M)
    {
        $this->e1M = $e1M;
    }

    /**
     * @return mixed
     */
    public function getE2M()
    {
        return $this->e2M;
    }

    /**
     * @param mixed $e2M
     */
    public function setE2M($e2M)
    {
        $this->e2M = $e2M;
    }

    /**
     * @return mixed
     */
    public function getE2Dly()
    {
        return $this->e2Dly;
    }

    /**
     * @param mixed $e2Dly
     */
    public function setE2Dly($e2Dly)
    {
        $this->e2Dly = $e2Dly;
    }

    /**
     * @return mixed
     */
    public function getE2Per()
    {
        return $this->e2Per;
    }

    /**
     * @param mixed $e2Per
     */
    public function setE2Per($e2Per)
    {
        $this->e2Per = $e2Per;
    }

    /**
     * @return mixed
     */
    public function getE1Per()
    {
        return $this->e1Per;
    }

    /**
     * @param mixed $e1Per
     */
    public function setE1Per($e1Per)
    {
        $this->e1Per = $e1Per;
    }

    /**
     * @return mixed
     */
    public function getPhCmd()
    {
        return $this->ph_cmd;
    }

    /**
     * @param mixed $ph_cmd
     */
    public function setPhCmd($ph_cmd)
    {
        $this->ph_cmd = $ph_cmd;
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

    public function setData($data = null)
    {
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        array_key_exists("pushCfg", $data) && $this->setPushCfg($data['pushCfg']);
        array_key_exists("spPer", $data) && $this->setSpPer($data['spPer']);
        array_key_exists("uvcPer", $data) && $this->setUvcPer($data['uvcPer']);
        array_key_exists("lPer", $data) && $this->setLPer($data['lPer']);
        array_key_exists("e1Per", $data) && $this->setE1Per($data['e1Per']);
        array_key_exists("e2Per", $data) && $this->setE2Per($data['e2Per']);
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
        array_key_exists("phCmd", $data) && $this->setPhCmd($data['phCmd']);


        array_key_exists("e1Dly", $data) && $this->setE1Dly($data['e1Dly']);
        array_key_exists("e1M", $data) && $this->setE1M($data['e1M']);
        array_key_exists("e2Dly", $data) && $this->setE2Dly($data['e2Dly']);
        array_key_exists("e2M", $data) && $this->setE2M($data['e2M']);
        array_key_exists("e1S", $data) && $this->setE1S($data['e1S']);
        array_key_exists("e2S", $data) && $this->setE2S($data['e2S']);


    }


}
