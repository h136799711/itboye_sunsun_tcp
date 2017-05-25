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
        if (!is_null($this->getTh())) {
            $data['th'] = $this->getTh();
        }
        if (!is_null($this->getTl())) {
            $data['tl'] = $this->getTl();
        }
        if (!is_null($this->getPhh())) {
            $data['phh'] = $this->getPhh();
        }
        if (!is_null($this->getPhl())) {
            $data['phl'] = $this->getPhl();
        }
        if (!is_null($this->getPhDly())) {
            $data['ph_dly'] = $this->getPhDly();
        }
        if (!is_null($this->getPhCmd())) {
            $data['ph_cmd'] = $this->getPhCmd();
        }

        return $data;
    }

    public function setData($data)
    {
        array_key_exists("ph_dly", $data) && $this->setPhDly($data['ph_dly']);
        array_key_exists("ph_cmd", $data) && $this->setPhCmd($data['ph_cmd']);
        array_key_exists("phh", $data) && $this->setPhh($data['phh']);
        array_key_exists("phl", $data) && $this->setPhl($data['phl']);
        array_key_exists("dCyc", $data) && $this->setDCyc($data['dCyc']);
        array_key_exists("pushCfg", $data) && $this->setPushCfg($data['pushCfg']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        array_key_exists("th", $data) && $this->setTh($data['th']);
        array_key_exists("tl", $data) && $this->setTl($data['tl']);

    }


    private $th;
    private $tl;
    private $pushCfg;
    private $devLock;
    private $dCyc;
    private $phh;
    private $phl;
    //单位秒。
    //PH校准命令发送后，等待该延迟后完成校准转换
    private $ph_dly;
    /**
     * 设置PH校准命令
     * @var
     */
    private $ph_cmd;

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
    public function getPhDly()
    {
        return $this->ph_dly;
    }

    /**
     * @param mixed $ph_dly
     */
    public function setPhDly($ph_dly)
    {
        $this->ph_dly = $ph_dly;
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


}