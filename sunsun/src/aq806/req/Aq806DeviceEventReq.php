<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\req;

use sunsun\po\BaseReqPo;

/**
 * Class Aq806HbReq
 * 设备事件
 * @package sunsun\aq806\req
 */
class Aq806DeviceEventReq extends BaseReqPo
{
    private $code;
    private $t;

    public function getEventInfo(){
        $codeDesc = $this->getCodeDesc();
        return [
            'code'=>$codeDesc,
            't'=>$this->getT()
        ];
    }

    public function getCodeDesc(){
//        0：无操作
//1：实时温度推送（服务器记录温度）
//2：加热棒过温异常
//3：温度传感器1异常
//4：温度传感器2异常
//5：加热丝开路异常
        switch ($this->code){
            case 0:
                return "no action";
            case 1:
                return "Real-time temperature push（Server record temperature）";
            case 2:
                return "Abnormal heating rod temperature";
            case 3:
                return "Temperature sensor 1 anomaly";
            case 4:
                return "Temperature sensor 2 anomaly";
            case 5:
                return "Heating wire open circuit anomaly";
            default:break;
        }
        return "Unknown";
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


    public function __construct($data=null)
    {
        $this->setReqType(Aq806ReqType::Event);
        if(!empty($data)){
            $this->setSn($data['sn']);
            $this->setCode($data['code']);
            $this->setT($data['t']);
        }
    }

    function toDataArray()
    {
        return [
            'reqType'=>$this->getReqType(),
            'sn'=>$this->getSn(),

        ];
    }


}