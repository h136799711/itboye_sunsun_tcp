<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq136\resp;


use sunsun\po\BaseReqPo;
use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseControlDeviceClientResp;

/**
 * Class Aq136HbReq
 * 设备状态响应包
 * @package sunsun\aq136\req
 */
class Aq136CtrlDeviceResp extends BaseControlDeviceClientResp implements ToDbEntityArrayInterface
{
    private $f;
    private $rt;
    private $th;
    private $tl;
    private $t;
    private $wh;
    private $m;
    private $sw;
    private $per;
    private $pushCfg;
    private $dCyc;
    private $devLock;
    private $updState;
    private $tz;

    public function __construct(BaseReqPo $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq136RespType::Control);
    }

    function toDbEntityArray()
    {

        $data = [];
        $data['update_time'] = time();

        if (!is_null($this->getTz())) {
            $data['tz'] = $this->getTz();
        }
        if (!is_null($this->getWh())) {
            $data['wh'] = $this->getWh();
        }
        if (!is_null($this->getM())) {
            $data['m'] = $this->getM();
        }
        if (!is_null($this->getSw())) {
            $data['sw'] = $this->getSw();
        }
        if (!is_null($this->getF())) {
            $data['f'] = $this->getF();
        }
        if (!is_null($this->getRt())) {
            $data['rt'] = $this->getRt();
        }
        if (!is_null($this->getT())) {
            $data['t'] = $this->getT();
        }
        if (!is_null($this->getTh())) {
            $data['th'] = $this->getTh();
        }
        if (!is_null($this->getTl())) {
            $data['tl'] = $this->getTl();
        }
        if (!is_null($this->getPer())) {
            $data['per'] = $this->getPer();
            if (is_array($data['per'])) {
                $data['per'] = json_encode($data['per']);
            }
        }

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

        if (!is_null($this->getDCyc())) {
            $data['d_cyc'] = $this->getDCyc();
        }
        return $data;
    }

    /**
     * @return mixed
     */
    public function getTz()
    {
        return $this->tz;
    }

    /**
     * @param mixed $tz
     */
    public function setTz($tz)
    {
        $this->tz = $tz;
    }

    /**
     * @return mixed
     */
    public function getWh()
    {
        return $this->wh;
    }

    /**
     * @param mixed $wh
     */
    public function setWh($wh)
    {
        $this->wh = $wh;
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
    public function getSw()
    {
        return $this->sw;
    }

    /**
     * @param mixed $sw
     */
    public function setSw($sw)
    {
        $this->sw = $sw;
    }

    /**
     * @return mixed
     */
    public function getF()
    {
        return $this->f;
    }

    /**
     * @param mixed $f
     */
    public function setF($f)
    {
        $this->f = $f;
    }

    /**
     * @return mixed
     */
    public function getRt()
    {
        return $this->rt;
    }

    /**
     * @param mixed $rt
     */
    public function setRt($rt)
    {
        $this->rt = $rt;
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
    public function getPer()
    {
        return $this->per;
    }

    /**
     * @param mixed $per
     */
    public function setPer($per)
    {
        $this->per = $per;
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
     * 设备传输过来的数据转换成该类
     * @param $data
     */
    public function setData($data = null)
    {
        array_key_exists("sn", $data) && $this->setSn($data['sn']);
        array_key_exists("t", $data) && $this->setT($data['t']);
        array_key_exists("th", $data) && $this->setTh($data['th']);
        array_key_exists("tl", $data) && $this->setTl($data['tl']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        $this->setUpdState(-1);
        array_key_exists("updState", $data) && $this->setUpdState($data['updState']);
        array_key_exists("push_cfg", $data) && $this->setPushCfg($data['push_cfg']);
        array_key_exists("d_cyc", $data) && $this->setDCyc($data['d_cyc']);
        array_key_exists("wh", $data) && $this->setWh($data['wh']);
        array_key_exists("sw", $data) && $this->setSw($data['sw']);
        array_key_exists("m", $data) && $this->setM($data['m']);
        array_key_exists("per", $data) && $this->setPer($data['per']);
        array_key_exists("f", $data) && $this->setF($data['f']);
        array_key_exists("rt", $data) && $this->setRt($data['rt']);
        array_key_exists("tz", $data) && $this->setTz($data['tz']);

    }

    public function toDataArray()
    {

        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            't' => $this->getT(),
            'th' => $this->getTh(),
            'tl' => $this->getTl(),
            'devLock' => $this->getDevLock(),
            'push_cfg' => $this->getPushCfg(),
            'd_cyc' => $this->getDCyc(),
            'sw' => $this->getSw(),
            'm' => $this->getM(),
            'per' => $this->getPer(),
            'f' => $this->getF(),
            'rt' => $this->getRt(),
            'wh' => $this->getWh(),
            'tz' => $this->getTz()
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
//                return  $key . " is null value";
//            }
//        }
        return "";
    }
}