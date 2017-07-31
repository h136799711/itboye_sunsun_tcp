<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\req;

use sunsun\po\BaseReqPo;

/**
 * Class AdtHbReq
 * 设置设备
 * @package sunsun\adt\req
 */
class AdtCtrlDeviceReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(AdtReqType::Control);
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
        if (!is_null($this->getMode())) {
            $data['mode'] = $this->getMode();
        }
        if (!is_null($this->getPer())) {
            if(is_array($this->getPer())){
                $data['per'] = json_encode($this->getPer());
            }else{
                $data['per'] = $this->getPer();
            }
        }

        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }

        return $data;
    }

    private $pushCfg;
    private $devLock;
    private $mode;
    private $per;

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
        array_key_exists("mode", $data) && $this->setMode($data['mode']);
        array_key_exists("per", $data) && $this->setPer($data['per']);
    }

}