<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\req;

use sunsun\po\BaseReqPo;

/**
 * Class FilterVatHbReq
 * 设置设备
 * @package sunsun\filter_vat\req
 */
class FilterVatCtrlDeviceReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(FilterVatReqType::Control);
        if (!empty($data)) {
            $this->setSn($data['sn']);
        }
    }

    function toDataArray()
    {
        $data = [];

        $data['reqType'] = $this->getReqType();
        $data['sn'] = $this->getSn();

        if (!is_null($this->getClEn())) {
            $data['clEn'] = $this->getClEn();
        }
        if (!is_null($this->getClWeek())) {
            $data['clWeek'] = $this->getClWeek();
        }
        if (!is_null($this->getClTm())) {
            $data['clTm'] = $this->getClTm();
        }
        if (!is_null($this->getClDur())) {
            $data['clDur'] = $this->getClDur();
        }
        if (!is_null($this->getClState())) {
            $data['clState'] = $this->getClState();
        }
        if (!is_null($this->getClCfg())) {
            $data['clCfg'] = $this->getClCfg();
        }
        if (!is_null($this->getUvOn())) {
            $data['uvOn'] = $this->getUvOn();
        }
        if (!is_null($this->getUvOff())) {
            $data['uvOff'] = $this->getUvOff();
        }
        if (!is_null($this->getUvWH())) {
            $data['uvWH'] = $this->getUvWH();
        }
        if (!is_null($this->getUvCfg())) {
            $data['uvCfg'] = $this->getUvCfg();
        }
        if (!is_null($this->getOutStateA())) {
            $data['outStateA'] = $this->getOutStateA();
        }
        if (!is_null($this->getOutStateB())) {
            $data['outStateB'] = $this->getOutStateB();
        }
        if (!is_null($this->getDevLock())) {
            $data['devLock'] = $this->getDevLock();
        }

        return $data;
    }

    private $clEn;
    private $clWeek;
    private $clTm;
    private $clDur;
    private $clState;
    private $clCfg;
    private $uvOn;
    private $uvOff;
    private $uvWH;
    private $uvCfg;
    private $outStateA;
    private $outStateB;
    private $devLock;

    /**
     * @return mixed
     */
    public function getClEn()
    {
        return $this->clEn;
    }

    /**
     * @param mixed $clEn
     */
    public function setClEn($clEn)
    {
        $this->clEn = $clEn;
    }

    /**
     * @return mixed
     */
    public function getClWeek()
    {
        return $this->clWeek;
    }

    /**
     * @param mixed $clWeek
     */
    public function setClWeek($clWeek)
    {
        $this->clWeek = $clWeek;
    }

    /**
     * @return mixed
     */
    public function getClTm()
    {
        return $this->clTm;
    }

    /**
     * @param mixed $clTm
     */
    public function setClTm($clTm)
    {
        $this->clTm = $clTm;
    }

    /**
     * @return mixed
     */
    public function getClDur()
    {
        return $this->clDur;
    }

    /**
     * @param mixed $clDur
     */
    public function setClDur($clDur)
    {
        $this->clDur = $clDur;
    }

    /**
     * @return mixed
     */
    public function getClState()
    {
        return $this->clState;
    }

    /**
     * @param mixed $clState
     */
    public function setClState($clState)
    {
        $this->clState = $clState;
    }

    /**
     * @return mixed
     */
    public function getClCfg()
    {
        return $this->clCfg;
    }

    /**
     * @param mixed $clCfg
     */
    public function setClCfg($clCfg)
    {
        $this->clCfg = $clCfg;
    }

    /**
     * @return mixed
     */
    public function getUvOn()
    {
        return $this->uvOn;
    }

    /**
     * @param mixed $uvOn
     */
    public function setUvOn($uvOn)
    {
        $this->uvOn = $uvOn;
    }

    /**
     * @return mixed
     */
    public function getUvOff()
    {
        return $this->uvOff;
    }

    /**
     * @param mixed $uvOff
     */
    public function setUvOff($uvOff)
    {
        $this->uvOff = $uvOff;
    }

    /**
     * @return mixed
     */
    public function getUvWH()
    {
        return $this->uvWH;
    }

    /**
     * @param mixed $uvWH
     */
    public function setUvWH($uvWH)
    {
        $this->uvWH = $uvWH;
    }

    /**
     * @return mixed
     */
    public function getUvCfg()
    {
        return $this->uvCfg;
    }

    /**
     * @param mixed $uvCfg
     */
    public function setUvCfg($uvCfg)
    {
        $this->uvCfg = $uvCfg;
    }

    /**
     * @return mixed
     */
    public function getOutStateA()
    {
        return $this->outStateA;
    }

    /**
     * @param mixed $outStateA
     */
    public function setOutStateA($outStateA)
    {
        $this->outStateA = $outStateA;
    }

    /**
     * @return mixed
     */
    public function getOutStateB()
    {
        return $this->outStateB;
    }

    /**
     * @param mixed $outStateB
     */
    public function setOutStateB($outStateB)
    {
        $this->outStateB = $outStateB;
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
        array_key_exists("clEn", $data) && $this->setClEn($data['clEn']);
        array_key_exists("clWeek", $data) && $this->setClWeek($data['clWeek']);
        array_key_exists("clTm", $data) && $this->setClTm($data['clTm']);
        array_key_exists("clDur", $data) && $this->setClDur($data['clDur']);
        array_key_exists("clState", $data) && $this->setClState($data['clState']);
        array_key_exists("clCfg", $data) && $this->setClCfg($data['clCfg']);
        array_key_exists("uvOn", $data) && $this->setUvOn($data['uvOn']);
        array_key_exists("uvOff", $data) && $this->setUvOff($data['uvOff']);
        array_key_exists("uvWH", $data) && $this->setUvWH($data['uvWH']);
        array_key_exists("uvCfg", $data) && $this->setUvCfg($data['uvCfg']);
        array_key_exists("outStateA", $data) && $this->setOutStateA($data['outStateA']);
        array_key_exists("outStateB", $data) && $this->setOutStateB($data['outStateB']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);

    }


}