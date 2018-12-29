<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:53
 */

namespace sunsun\po;

use sunsun\helper\SetDataHelper;
use sunsun\transfer_station\client\interfaces\SetDataInterface;

abstract class BaseRespPo implements SetDataInterface
{



    public function __construct(BaseReqPo $req = null)
    {
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
    }

    /**
     * @var integer
     */
    private $respType;
    /**
     * @var integer
     */
    private $sn;

    /**
     * @return integer
     */
    public function getRespType()
    {
        return intval($this->respType);
    }

    /**
     * @param integer $respType
     */
    public function setRespType($respType)
    {
        $this->respType = $respType;
    }


    /**
     * 获取响应包序号
     * @return integer
     */
    public function getSn()
    {
        return intval($this->sn);
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
        SetDataHelper::setData($this, $data);
    }

    public function check()
    {
        return '';
    }

}