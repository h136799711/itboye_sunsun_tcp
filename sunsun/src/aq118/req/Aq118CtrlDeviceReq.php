<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq118\req;

use sunsun\server\req\BaseControlDeviceServerReq;

/**
 * Class Aq118HbReq
 * 设置设备
 * @package sunsun\aq118\req
 */
class Aq118CtrlDeviceReq extends BaseControlDeviceServerReq
{

    private $devLock;
    private $dCyc;
    private $tCfg;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq118ReqType::Control);
    }

    function toDataArray()
    {
        $data = [];

        $data['reqType'] = $this->getReqType();
        $data['sn'] = $this->getSn();

        if (!is_null($this->getDevLock())) {
            $data['devLock'] = $this->getDevLock();
        }
        if (!is_null($this->getDCyc())) {
            $data['d_cyc'] = $this->getDCyc();
        }
        if (!is_null($this->getTCfg())) {
            $data['t_cfg'] = $this->getTCfg();
        }

        return $data;
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

    public function setData($data = null)
    {
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        array_key_exists("d_cyc", $data) && $this->setDCyc($data['d_cyc']);
        array_key_exists("t_cfg", $data) && $this->setTCfg($data['t_cfg']);

    }


}