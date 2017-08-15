<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\resp;


use sunsun\adt\req\AdtDeviceInfoReq;
use sunsun\po\BaseRespPo;

/**
 * Class AdtHbReq
 * 设备状态响应包
 * @package sunsun\adt\req
 */
class AdtDeviceInfoResp extends BaseRespPo
{

    private $sw;// 总开关 20170809 增加
    private $w;
    private $r;
    private $g;
    private $b;
    private $mode;
    private $per;
    private $pushCfg;
    /**
     * 设备锁机状态
     * 0：未锁机，可局域网查找
     * 1：锁机，局域网隐藏
     * @var
     */
    private $devLock;
    /**
     * 固件更新状态
     * 0 -100：更新进度百分比，更新成功为100
     * 101：更新失败，硬件重启后该字段隐藏
     */
    private $updState;

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
    public function getW()
    {
        return $this->w;
    }

    /**
     * @param mixed $w
     */
    public function setW($w)
    {
        $this->w = $w;
    }

    /**
     * @return mixed
     */
    public function getR()
    {
        return $this->r;
    }

    /**
     * @param mixed $r
     */
    public function setR($r)
    {
        $this->r = $r;
    }

    /**
     * @return mixed
     */
    public function getG()
    {
        return $this->g;
    }

    /**
     * @param mixed $g
     */
    public function setG($g)
    {
        $this->g = $g;
    }

    /**
     * @return mixed
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * @param mixed $b
     */
    public function setB($b)
    {
        $this->b = $b;
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


    public function __construct(AdtDeviceInfoReq $req = null)
    {
        $this->setRespType(AdtRespType::DeviceInfo);
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
    }

    /**
     * 设备传输过来的数据转换成该类
     * @param $data
     */
    public function setData($data)
    {
        array_key_exists("sn", $data) && $this->setSn($data['sn']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        $this->setUpdState(-1);
        array_key_exists("updState", $data) && $this->setUpdState($data['updState']);
        array_key_exists("push_cfg", $data) && $this->setPushCfg($data['push_cfg']);
        array_key_exists("per", $data) && $this->setPer($data['per']);
        array_key_exists("mode", $data) && $this->setMode($data['mode']);
        array_key_exists("r", $data) && $this->setR($data['r']);
        array_key_exists("g", $data) && $this->setG($data['g']);
        array_key_exists("b", $data) && $this->setB($data['b']);
        array_key_exists("w", $data) && $this->setW($data['w']);
        array_key_exists("sw", $data) && $this->setSw($data['sw']);
    }

    public function toDataArray()
    {

        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'devLock' => $this->getDevLock(),
            'push_cfg' => $this->getPushCfg(),
            'r'=>$this->getR(),
            'g'=>$this->getG(),
            'b'=>$this->getB(),
            'w'=>$this->getW(),
            'mode'=>$this->getMode(),
            'per'=>$this->getPer(),
            'sw'=>$this->getSw()
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
//            if (is_null($item)) {
//                return  $key . " is null value";
//            }
//        }
        return "";
    }

}