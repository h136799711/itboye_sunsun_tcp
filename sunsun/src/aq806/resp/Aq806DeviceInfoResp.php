<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\resp;


use sunsun\aq806\req\Aq806DeviceInfoReq;
use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseDeviceInfoClientResp;

/**
 * Class Aq806HbReq
 * 设备状态响应包
 * @package sunsun\aq806\req
 */
class Aq806DeviceInfoResp extends BaseDeviceInfoClientResp implements ToDbEntityArrayInterface
{
    function toDbEntityArray()
    {

        $data = [];
        $data['update_time'] = time();
        if (!is_null($this->getT())) {
            $data['t'] = $this->getT();
        }
        if (!is_null($this->getPh())) {
            $data['ph'] = $this->getPh();
        }
        if (!is_null($this->getOut())) {
            $data['out_ctrl'] = $this->getOut();
        }
        if (!is_null($this->getTMax())) {
            $data['t_max'] = $this->getTMax();
        }
        if (!is_null($this->getFault())) {
            $data['fault'] = $this->getFault();
        }
        if (!is_null($this->getTh())) {
            $data['th'] = $this->getTh();
        }
        if (!is_null($this->getTl())) {
            $data['tl'] = $this->getTl();
        }
        if (!is_null($this->getPP())) {
            $data['p_p'] = $this->getPP();
        }
        if (!is_null($this->getUvcP())) {
            $data['uvc_p'] = $this->getUvcP();
        }
        if (!is_null($this->getSpP())) {
            $data['sp_p'] = $this->getSpP();
        }
        if (!is_null($this->getLP())) {
            $data['l_p'] = $this->getLP();
        }
        if (!is_null($this->getE1Per())) {
            $data['e1_per'] = $this->getE1Per();
            if (is_array($data['e1_per'])) {
                $data['e1_per'] = json_encode($data['e1_per']);
            }
        }
        if (!is_null($this->getE2Per())) {
            $data['e2_per'] = $this->getE2Per();
            if (is_array($data['e2_per'])) {
                $data['e2_per'] = json_encode($data['e2_per']);
            }
        }
        if (!is_null($this->getLPer())) {
            $data['l_per'] = $this->getLPer();
            if (is_array($data['l_per'])) {
                $data['l_per'] = json_encode($data['l_per']);
            }
        }
        if (!is_null($this->getUvcPer())) {
            $data['uvc_per'] = $this->getUvcPer();
            if (is_array($data['uvc_per'])) {
                $data['uvc_per'] = json_encode($data['uvc_per']);
            }
        }
        if (!is_null($this->getSpPer())) {
            $data['sp_per'] = $this->getSpPer();
            if (is_array($data['sp_per'])) {
                $data['sp_per'] = json_encode($data['sp_per']);
            }
        }
        if (!is_null($this->getExDev())) {
            $data['ex_dev'] = $this->getExDev();
        }

        if (!is_null($this->getDevLock())) {
            $data['dev_lock'] = $this->getDevLock();
        }
        if (!is_null($this->getUpdState()) && $this->getUpdState() > -1) {
            $data['upd_state'] = $this->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }


        if (!is_null($this->getPushCfg())) {
            $data['push_cfg'] = $this->getPushCfg();
        }

        if (!is_null($this->getDCyc())) {
            $data['d_cyc'] = $this->getDCyc();
        }

        if (!is_null($this->getUvWh())) {
            $data['uv_wh'] = $this->getUvWh();
        }

        if (!is_null($this->getPWh())) {
            $data['p_wh'] = $this->getPWh();
        }

        if (!is_null($this->getLWh())) {
            $data['l_wh'] = $this->getLWh();
        }
        if (!is_null($this->getE1Dly())) {
            $data['e1_dly'] = $this->getE1Dly();
        }
        if (!is_null($this->getE2Dly())) {
            $data['e2_dly'] = $this->getE2Dly();
        }
        if (!is_null($this->getE1M())) {
            $data['e1_m'] = $this->getE1M();
        }
        if (!is_null($this->getE2M())) {
            $data['e2_m'] = $this->getE2M();
        }
        return $data;
    }


    //t	1	int		实时温度	温度值的10倍值
    private $t;
    //ph	1	int		实时PH值	数值为实际PH值的100倍
    private $ph;
    //out	1	int		输出继电器控制值
    //Bit0：灯光继电器状态
    //0：关闭，1：打开
    //Bit1：冲浪水泵继电器状态
    //0：关闭，1：打开
    //Bit4：杀菌灯继电器状态
    //0：关闭，1：打开
    //Bit7：手动和自动模式状态
    //0：手动模式，1：自动模式
    private $out;
    //tMax	1	int		温控加热上限温度	温度值的10倍值
    private $tMax;
    //fault	1	int		故障状态值	Bit1 - 0：水温状态
    //00：正常，01：过低，10：过高
    //Bit2：杀菌灯故障状态
    //0：正常，1：故障
    //Bit3：冲浪水泵故障状态
    //0：正常，1：故障
    //Bit4：照明灯故障状态
    //0：正常，1：故障
    //Bit5：备用电源（循环水泵）故障状态
    //0：正常，1：故障
    //Bit4：水位状态
    //0：正常，1：过低
    //Bit9 - 8：PH状态
    //00：正常，01：过低，10：过高
    private $fault;
    //th	1	int		水温异常高温阈值	温度值的10倍值
    private $th;
    //tl	1	int		水温异常低温阈值	温度值的10倍值
    private $tl;
    //p_p	1	int		循环水泵功率	单位瓦特
    private $p_p;
    //uvc_p	1	int		杀菌灯功率	单位瓦特
    private $uvc_p;
    //sp_p	1	int		冲浪水泵功率	单位瓦特
    private $sp_p;
    //l_p	1	int		照明灯功率	单位瓦特
    private $l_p;
    //l_per	1	时段数组项	3	照明灯时间段	一天共三个时间段
    private $l_per;
    private $e1_per;
    private $e2_per;
    //uvc_per	1	时段数组项	3	杀菌灯时间段	一天共三个时间段
    private $uvc_per;
    //sp_per	1	时段数组项	h	冲浪水泵时间段	一天共三个时间段
    private $sp_per;
    //exDev	1	String	V8	外扩挂载设备标识
    //AQ107：AQ107底板
    //AQ209：AQ209底板
    //AQ805：AQ805底板
    //AQ806：AQ806底板
    //AQ211：AQ211底板
    //AQ210：AQ210底板
    private $exDev;
    private $pushCfg;
    private $dCyc;
    private $uvWh;
    private $pWh;
    private $lWh;
    private $e1Dly;
    private $e1M;
    private $e2M;
    private $e2Dly;

    /**
     * @return mixed
     */
    public function getE1Dly()
    {
        return $this->e1Dly;
    }

    /**
     * @param mixed $e1Dly
     */
    public function setE1Dly($e1Dly)
    {
        $this->e1Dly = $e1Dly;
    }

    /**
     * @return mixed
     */
    public function getE1M()
    {
        return $this->e1M;
    }

    /**
     * @param mixed $e1M
     */
    public function setE1M($e1M)
    {
        $this->e1M = $e1M;
    }

    /**
     * @return mixed
     */
    public function getE2M()
    {
        return $this->e2M;
    }

    /**
     * @param mixed $e2M
     */
    public function setE2M($e2M)
    {
        $this->e2M = $e2M;
    }

    /**
     * @return mixed
     */
    public function getE2Dly()
    {
        return $this->e2Dly;
    }

    /**
     * @param mixed $e2Dly
     */
    public function setE2Dly($e2Dly)
    {
        $this->e2Dly = $e2Dly;
    }

    /**
     * @return mixed
     */
    public function getE1Per()
    {
        return $this->e1_per;
    }

    /**
     * @param mixed $e1_per
     */
    public function setE1Per($e1_per)
    {
        $this->e1_per = $e1_per;
    }

    /**
     * @return mixed
     */
    public function getE2Per()
    {
        return $this->e2_per;
    }

    /**
     * @param mixed $e2_per
     */
    public function setE2Per($e2_per)
    {
        $this->e2_per = $e2_per;
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

    /**
     * @return mixed
     */
    public function getUvWh()
    {
        return $this->uvWh;
    }

    /**
     * @param mixed $uvWh
     */
    public function setUvWh($uvWh)
    {
        $this->uvWh = $uvWh;
    }

    /**
     * @return mixed
     */
    public function getPWh()
    {
        return $this->pWh;
    }

    /**
     * @param mixed $pWh
     */
    public function setPWh($pWh)
    {
        $this->pWh = $pWh;
    }

    /**
     * @return mixed
     */
    public function getLWh()
    {
        return $this->lWh;
    }

    /**
     * @param mixed $lWh
     */
    public function setLWh($lWh)
    {
        $this->lWh = $lWh;
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
    public function getOut()
    {
        return $this->out;
    }

    /**
     * @param mixed $out
     */
    public function setOut($out)
    {
        $this->out = $out;
    }

    /**
     * @return mixed
     */
    public function getTMax()
    {
        return $this->tMax;
    }

    /**
     * @param mixed $tMax
     */
    public function setTMax($tMax)
    {
        $this->tMax = $tMax;
    }

    /**
     * @return mixed
     */
    public function getFault()
    {
        return $this->fault;
    }

    /**
     * @param mixed $fault
     */
    public function setFault($fault)
    {
        $this->fault = $fault;
    }

    /**
     * @return mixed
     */
    public function getTh()
    {
        return $this->th;
    }

    /**
     * @param mixed $th
     */
    public function setTh($th)
    {
        $this->th = $th;
    }

    /**
     * @return mixed
     */
    public function getTl()
    {
        return $this->tl;
    }

    /**
     * @param mixed $tl
     */
    public function setTl($tl)
    {
        $this->tl = $tl;
    }

    /**
     * @return mixed
     */
    public function getPP()
    {
        return $this->p_p;
    }

    /**
     * @param mixed $p_p
     */
    public function setPP($p_p)
    {
        $this->p_p = $p_p;
    }

    /**
     * @return mixed
     */
    public function getUvcP()
    {
        return $this->uvc_p;
    }

    /**
     * @param mixed $uvc_p
     */
    public function setUvcP($uvc_p)
    {
        $this->uvc_p = $uvc_p;
    }

    /**
     * @return mixed
     */
    public function getSpP()
    {
        return $this->sp_p;
    }

    /**
     * @param mixed $sp_p
     */
    public function setSpP($sp_p)
    {
        $this->sp_p = $sp_p;
    }

    /**
     * @return mixed
     */
    public function getLP()
    {
        return $this->l_p;
    }

    /**
     * @param mixed $l_p
     */
    public function setLP($l_p)
    {
        $this->l_p = $l_p;
    }

    /**
     * @return mixed
     */
    public function getLPer()
    {
        return $this->l_per;
    }

    /**
     * @param mixed $l_per
     */
    public function setLPer($l_per)
    {
        $this->l_per =  $l_per;
    }

    /**
     * @return mixed
     */
    public function getUvcPer()
    {
        return $this->uvc_per;
    }

    /**
     * @param mixed $uvc_per
     */
    public function setUvcPer($uvc_per)
    {
        $this->uvc_per = $uvc_per;
    }

    /**
     * @return mixed
     */
    public function getSpPer()
    {
        return $this->sp_per;
    }

    /**
     * @param mixed $sp_per
     */
    public function setSpPer($sp_per)
    {
        $this->sp_per = $sp_per;
    }

    /**
     * @return mixed
     */
    public function getExDev()
    {
        return $this->exDev;
    }

    /**
     * @param mixed $exDev
     */
    public function setExDev($exDev)
    {
        $this->exDev = $exDev;
    }


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

    public function __construct(Aq806DeviceInfoReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq806RespType::DeviceInfo);
    }

    /**
     * 设备传输过来的数据转换成该类
     * @param $data
     */
    public function setData($data = null)
    {
        array_key_exists("sn", $data) && $this->setSn($data['sn']);
        array_key_exists("t", $data) && $this->setT($data['t']);
        array_key_exists("ph", $data) && $this->setPh($data['ph']);
        array_key_exists("out", $data) && $this->setOut($data['out']);
        array_key_exists("tMax", $data) && $this->setTMax($data['tMax']);
        array_key_exists("fault", $data) && $this->setFault($data['fault']);
        array_key_exists("th", $data) && $this->setTh($data['th']);
        array_key_exists("tl", $data) && $this->setTl($data['tl']);
        array_key_exists("p_p", $data) && $this->setPP($data['p_p']);
        array_key_exists("uvc_p", $data) && $this->setUvcP($data['uvc_p']);
        array_key_exists("sp_p", $data) && $this->setSpP($data['sp_p']);
        array_key_exists("l_p", $data) && $this->setLP($data['l_p']);
        array_key_exists("l_per", $data) && $this->setLPer($data['l_per']);
        array_key_exists("uvc_per", $data) && $this->setUvcPer($data['uvc_per']);
        array_key_exists("sp_per", $data) && $this->setSpPer($data['sp_per']);
        array_key_exists("exDev", $data) && $this->setExDev($data['exDev']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        $this->setUpdState(-1);
        array_key_exists("updState", $data) && $this->setUpdState($data['updState']);
        array_key_exists("push_cfg", $data) && $this->setPushCfg($data['push_cfg']);
        array_key_exists("d_cyc", $data) && $this->setDCyc($data['d_cyc']);
        array_key_exists("uv_wh", $data) && $this->setUvWh($data['uv_wh']);
        array_key_exists("p_wh", $data) && $this->setPWh($data['p_wh']);
        array_key_exists("l_wh", $data) && $this->setLWh($data['l_wh']);
        array_key_exists("e1_per", $data) && $this->setE1Per($data['e1_per']);
        array_key_exists("e2_per", $data) && $this->setE2Per($data['e2_per']);
        array_key_exists("e1_dly", $data) && $this->setE1Dly($data['e1_dly']);
        array_key_exists("e1_m", $data) && $this->setE1M($data['e1_m']);
        array_key_exists("e2_dly", $data) && $this->setE2Dly($data['e2_dly']);
        array_key_exists("e2_m", $data) && $this->setE2M($data['e2_m']);
    }

    public function toDataArray()
    {

        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            't' => $this->getT(),
            'ph' => $this->getPh(),
            'out' => $this->getOut(),
            'tMax' => $this->getTMax(),
            'fault' => $this->getFault(),
            'th' => $this->getTh(),
            'tl' => $this->getTl(),
            'p_p' => $this->getPP(),
            'uvc_p' => $this->getUvcP(),
            'sp_p' => $this->getSpP(),
            'l_p' => $this->getLP(),
            'l_per' => $this->getLPer(),
            'uvc_per' => $this->getUvcPer(),
            'sp_per' => $this->getSpPer(),
            'exDev' => $this->getExDev(),
            'devLock' => $this->getDevLock(),
            'push_cfg' => $this->getPushCfg(),
            'd_cyc' => $this->getDCyc(),
            'uv_wh' => $this->getUvWh(),
            'p_wh' => $this->getPWh(),
            'l_wh' => $this->getLWh(),
            'e1_per' => $this->getE1Per(),
            'e2_per' => $this->getE2Per(),
            'e1_dly' => $this->getE1Dly(),
            'e1_m' => $this->getE1M(),
            'e2_m' => $this->getE2M(),
            'e2_dly' => $this->getE2Dly()
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