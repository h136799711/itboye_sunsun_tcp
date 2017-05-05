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
 * Class Aq806DeviceEventReq
 * 设备事件
 * @package sunsun\aq806\req
 */
class Aq806DeviceEventReq extends BaseReqPo
{
    private $code;
    private $ph;
    private $t;
    private $dyn;


    public function getEventInfo(){
        $codeDesc = $this->getCodeDesc();
        return [
            'code'=>$codeDesc,
            'ph'=>$this->getPh(),
            't'=>$this->getT(),
            'dyn'=>$this->getDyn()
        ];
    }


    public function getCodeDesc(){
        switch ($this->code){
            case 0:
                return "无操作";
            case 1:
                return "冲浪水泵异常";
            case 2:
                return "备用电源异常";
            case 3:
                return "照明灯异常";
            case 4:
                return "杀菌灯异常";
            case 5:
                return "水位过低";
            case 6:
                return "水温过低";
            case 7:
                return "水温过高";
            case 10:
                return "数据推送";
            default:break;
        }
        return "未知";
    }

    /**
     * @return mixed
     */
    public function getDyn()
    {
        return $this->dyn;
    }

    /**
     * @param mixed $dyn
     */
    public function setDyn($dyn)
    {
        $this->dyn = $dyn;
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


    public function __construct($data=null)
    {
        $this->setReqType(Aq806ReqType::Event);
        if(!empty($data)){
            $this->setSn($data['sn']);
            $this->setCode($data['code']);
            $this->setT(-1);
            $this->setDyn(-1);
            $this->setPh(-1);
            if(array_key_exists("t",$data)){
                $this->setT($data['t']);
            }

            if(array_key_exists("dyn",$data)){
                $this->setDyn($data['dyn']);
            }

            if(array_key_exists("ph",$data)){
                $this->setPh($data['ph']);
            }

        }
    }

    function toDataArray()
    {
        return [
            'reqType'=>$this->getReqType(),
            'sn'=>$this->getSn()
        ];
    }


}