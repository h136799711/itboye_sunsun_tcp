<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:53
 */

namespace sunsun\po;

abstract class BaseRespPo
{

    public function __construct(BaseReqPo $req = null)
    {
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
    }

    private $respType;
    private $sn;

    /**
     * @return mixed
     */
    public function getRespType()
    {
        return $this->respType;
    }

    /**
     * @param mixed $respType
     */
    public function setRespType($respType)
    {
        $this->respType = $respType;
    }


    /**
     * 获取响应包序号
     * @return mixed
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * 设置响应包序号
     * @param mixed $sn
     */
    public function setSn($sn)
    {
        $this->sn = $sn;
    }

    /*
     * 转化用于发送给设备的数据数组
     */
    abstract function toDataArray();

    public function setData($data = null)
    {

    }

    public function check()
    {
        return '';
    }

}