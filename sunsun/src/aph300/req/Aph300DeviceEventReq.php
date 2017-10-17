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
 * Class Aph300DeviceEventReq
 * 设备事件
 * @package sunsun\aph300\req
 */
class Aph300DeviceEventReq extends BaseReqPo
{
    private $code;
    private $ph;
    private $t;


    public function getEventInfo()
    {
        $codeDesc = $this->getCodeDesc();
        return [
            'code' => $codeDesc,
            'ph' => $this->getPh(),
            't' => $this->getT()
        ];
    }


    public function getCodeDesc()
    {
        switch ($this->code) {
            case 0:
                return "无操作";
            case 1:
                return "实时数据推送";
            case 2:
                return "高温报警";
            case 3:
                return "低温报警";
            case 4:
                return "PH过低报警";
            case 5:
                return "PH过高报警";
            default:
                break;
        }
        return "未知";
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
    public function getPh()
    {
        return $this->ph;
    }

    /**
     * @param mixed $ph
     */
    public function setPh($ph)
    {
        $this->ph = $ph;
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
        $this->setReqType(Aph300ReqType::Event);
        if (!empty($data)) {
            $this->setCode($data['code']);
            $this->setT(-1);
            $this->setPh(-1);
            if (array_key_exists("t", $data)) {
                $this->setT($data['t']);
            }

            if (array_key_exists("ph", $data)) {
                $this->setPh($data['ph']);
            }

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