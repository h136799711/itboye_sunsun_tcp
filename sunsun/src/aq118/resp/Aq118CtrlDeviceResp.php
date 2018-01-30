<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\resp;


use sunsun\aq118\req\Aq118CtrlDeviceReq;
use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseControlDeviceClientResp;

/**
 * Class Aq118HbReq
 * 设备状态响应包
 * @package sunsun\aq118\req
 */
class Aq118CtrlDeviceResp extends BaseControlDeviceClientResp implements ToDbEntityArrayInterface
{
    private $t;


    //t	1	int		实时温度	温度值的10倍值
    private $tCfg;
    private $dCyc;
    private $fault;
    private $devLock;
    private $updState;

    public function __construct(Aq118CtrlDeviceReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq118RespType::Control);
    }

    public function toDbEntityArray()
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
        if (!is_null($this->getT())) {
            $data['t'] = $this->getT();
        }
        if (!is_null($this->getDCyc())) {
            $data['d_cyc'] = $this->getDCyc();
        }
        if (!is_null($this->getFault())) {
            $data['fault'] = $this->getFault();
        }
        if (!is_null($this->getTCfg())) {
            $data['t_cfg'] = $this->getTCfg();
        }

        return $data;
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
    public function getTCfg()
    {
        return $this->tCfg;
    }

    /**
     * @param mixed $tCfg
     */
    public function setTCfg($tCfg)
    {
        $this->tCfg = $tCfg;
    }

    public function setData($data = null)
    {
        array_key_exists("sn", $data) && $this->setSn($data['sn']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        $this->setUpdState(-1);
        array_key_exists("updState", $data) && $this->setUpdState($data['updState']);
        array_key_exists("fault", $data) && $this->setFault($data['fault']);
        array_key_exists("d_cyc", $data) && $this->setDCyc($data['d_cyc']);
        array_key_exists("t_cfg", $data) && $this->setTCfg($data['t_cfg']);
        array_key_exists("t", $data) && $this->setT($data['t']);

    }

    public function toDataArray()
    {

        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'devLock' => $this->getDevLock()
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