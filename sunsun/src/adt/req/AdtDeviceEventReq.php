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
 * Class AdtDeviceEventReq
 * 设备事件
 * @package sunsun\adt\req
 */
class AdtDeviceEventReq extends BaseReqPo
{
    private $code;


    public function getEventInfo()
    {
        return [
            'code' => $this->getCode()
        ];
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(AdtReqType::Event);
        if (!empty($data)) {
            $this->setCode($data['code']);
        }
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn()
        ];
    }


}