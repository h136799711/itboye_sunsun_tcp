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


    public function getEventInfo()
    {
        $codeDesc = $this->getCodeDesc();
        return [
            'code' => $codeDesc,
            'ph' => $this->getPh(),
            't' => $this->getT(),
            'dyn' => $this->getDyn()
        ];
    }

    public function getDynDesc()
    {
        $dyn = intval($this->getDyn());
        if (empty($this->getDyn()) || $dyn < 0) return "";
        //照明灯动态
        $light_on = 1;
        $light_off = 2;
        //杀菌灯动态
        $Germicidal_on = 4;
        $Germicidal_off = 8;
        //冲浪泵动态
        $Surfing_pump_on = 16;
        $Surfing_pump_off = 32;
        //模式动态
        $Surfing_pump_auto = 64;
        $Surfing_pump_manual = 128;
        $desc = "";

        if (($dyn & $Surfing_pump_auto) == $Surfing_pump_auto) {
            $desc .= "进入自动模式;";
        }
        if (($dyn & $Surfing_pump_manual) == $Surfing_pump_manual) {
            $desc .= "进入手动模式;";
        }

        if (($dyn & $Surfing_pump_on) == $Surfing_pump_on) {
            $desc .= "冲浪泵启动了;";
        }
        if (($dyn & $Surfing_pump_off) == $Surfing_pump_off) {
            $desc .= "冲浪泵关闭了;";
        }

        if (($dyn & $Germicidal_on) == $Germicidal_on) {
            $desc .= "杀菌灯打开了;";
        }
        if (($dyn & $Germicidal_off) == $Germicidal_off) {
            $desc .= "杀菌灯关闭了;";
        }


        if (($dyn & $light_on) == $light_on) {
            $desc .= "照明灯打开了;";
        }
        if (($dyn & $light_off) == $light_off) {
            $desc .= "照明灯关闭了;";
        }

        return $desc;
    }

    public function getCodeDesc()
    {
        switch ($this->code) {
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
            case 11:
                return "动态提示";
            default:
                break;
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


    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq806ReqType::Event);
        if (!empty($data)) {
            $this->setCode($data['code']);
            $this->setT(-1);
            $this->setDyn(-1);
            $this->setPh(-1);
            if (array_key_exists("t", $data)) {
                $this->setT($data['t']);
            }

            if (array_key_exists("dyn", $data)) {
                $this->setDyn($data['dyn']);
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