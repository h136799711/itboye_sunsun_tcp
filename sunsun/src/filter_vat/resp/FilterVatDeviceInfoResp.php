<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\resp;


use sunsun\filter_vat\req\FilterVatDeviceInfoReq;
use sunsun\server\interfaces\ToDbEntityArrayInterface;
use sunsun\server\resp\BaseDeviceInfoClientResp;

/**
 * Class FilterVatHbReq
 * 设备状态响应包
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceInfoResp extends BaseDeviceInfoClientResp implements ToDbEntityArrayInterface
{
    public function toDbEntityArray()
    {
        $data = [];
        $data['update_time'] = time();
        if (!is_null($this->getT())) {
            $data['t'] = $this->getT();
        }
        if (!is_null($this->getClEn())) {
            $data['cl_en'] = $this->getClEn();
        }
        if (!is_null($this->getClWeek())) {
            $data['cl_week'] = $this->getClWeek();
        }
        if (!is_null($this->getClTm())) {
            $data['cl_tm'] = $this->getClTm();
        }
        if (!is_null($this->getClDur())) {
            $data['cl_dur'] = $this->getClDur();
        }
        if (!is_null($this->getClState())) {
            $data['cl_state'] = $this->getClState();
        }
        if (!is_null($this->getClSche())) {
            $data['cl_sche'] = $this->getClSche();
        }
        if (!is_null($this->getClCfg())) {
            $data['cl_cfg'] = $this->getClCfg();
        }
        if (!is_null($this->getUvOn())) {
            $data['uv_on'] = $this->getUvOn();
        }
        if (!is_null($this->getUvOff())) {
            $data['uv_off'] = $this->getUvOff();
        }
        if (!is_null($this->getUvWH())) {
            $data['uv_wh'] = $this->getUvWH();
        }
        if (!is_null($this->getUvCfg())) {
            $data['uv_cfg'] = $this->getUvCfg();
        }
        if (!is_null($this->getOutStateA())) {
            $data['out_state_a'] = $this->getOutStateA();
        }
        if (!is_null($this->getOutStateB())) {
            $data['out_state_b'] = $this->getOutStateB();
        }
        if (!is_null($this->getDevLock())) {
            $data['dev_lock'] = $this->getDevLock();
        }
        if (!is_null($this->getUpdState()) && $this->getUpdState() > -1) {
            $data['upd_state'] = $this->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }

        if (!is_null($this->getWsOffTm())) {
            $data['ws_off_tm'] = $this->getWsOffTm();
        }
        if (!is_null($this->getWsOnTm())) {
            $data['ws_on_tm'] = $this->getWsOnTm();
        }
        if (!is_null($this->getUvState())) {
            $data['uv_state'] = $this->getUvState();
        }

        if (!is_null($this->getObPer())) {
            $data['ob_per'] = $this->getObPer();
            if (is_array($data['ob_per'])) {
                $data['ob_per'] = json_encode($data['ob_per']);
            }
        }
        if (!is_null($this->getOaPer())) {
            $data['oa_per'] = $this->getOaPer();
            if (is_array($data['oa_per'])) {
                $data['oa_per'] = json_encode($data['oa_per']);
            }
        }

        return $data;
    }

    public function setData($data = null)
    {
        array_key_exists("sn", $data) && $this->setSn($data['sn']);
        array_key_exists("clEn", $data) && $this->setClEn($data['clEn']);
        array_key_exists("clWeek", $data) && $this->setClWeek($data['clWeek']);
        array_key_exists("clTm", $data) && $this->setClTm($data['clTm']);
        array_key_exists("clDur", $data) && $this->setClDur($data['clDur']);
        array_key_exists("clState", $data) && $this->setClState($data['clState']);
        array_key_exists("clSche", $data) && $this->setClSche($data['clSche']);
        array_key_exists("clCfg", $data) && $this->setClCfg($data['clCfg']);
        array_key_exists("uvOn", $data) && $this->setUvOn($data['uvOn']);
        array_key_exists("uvOff", $data) && $this->setUvOff($data['uvOff']);
        array_key_exists("uvWH", $data) && $this->setUvWH($data['uvWH']);
        array_key_exists("uvCfg", $data) && $this->setUvCfg($data['uvCfg']);
        array_key_exists("outStateA", $data) && $this->setOutStateA($data['outStateA']);
        array_key_exists("outStateB", $data) && $this->setOutStateB($data['outStateB']);
        array_key_exists("t", $data) && $this->setT($data['t']);
        array_key_exists("devLock", $data) && $this->setDevLock($data['devLock']);
        $this->setUpdState(-1);
        array_key_exists("updState", $data) && $this->setUpdState($data['updState']);
        array_key_exists("ob_per", $data) && $this->setObPer($data['ob_per']);
        array_key_exists("oa_per", $data) && $this->setOaPer($data['oa_per']);
        array_key_exists("ws_off_tm", $data) && $this->setWsOffTm($data['ws_off_tm']);
        array_key_exists("ws_on_tm", $data) && $this->setWsOnTm($data['ws_on_tm']);
        array_key_exists("uvState", $data) && $this->setUvState($data['uvState']);
    }

    public function toDataArray()
    {

        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'clEn' => $this->getClEn(),
            'clWeek' => $this->getClWeek(),
            'clTm' => $this->getClTm(),
            'clDur' => $this->getClDur(),
            'clState' => $this->getClState(),
            'clSche' => $this->getClSche(),
            'clCfg' => $this->getClCfg(),
            'uvOn' => $this->getUvOn(),
            'uvOff' => $this->getUvOff(),
            'uvWH' => $this->getUvWH(),
            'uvCfg' => $this->getUvCfg(),
            'outStateA' => $this->getOutStateA(),
            'outStateB' => $this->getOutStateB(),
            'devLock' => $this->getDevLock(),
            't' => $this->getT(),
            'oaPer' => $this->getOaPer(),
            'wsOffTm' => $this->getWsOffTm(),
            'wsOnTm' => $this->getWsOnTm(),
            'obPer' => $this->getObPer(),
            'uvState' => $this->getUvState(),
        ];
        if ($this->getUpdState() == -1) {
            $data['updState'] = 0;
        } else {
            $data['updState'] = $this->getUpdState();
        }

        return $data;
    }

    public function __construct(FilterVatDeviceInfoReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FilterVatRespType::DeviceInfo);
    }



    private $obPer;
    private $oaOnTm;
    private $oaOffTm;
    private $t;
    /**
     * 定时清洗使能
     *
     * 0: 禁用
     * 1: 开启
     * @var int
     */
    private $clEn;

    /**
     * int 1
     * bit0-bit6对应周一到周日
     * Bit设置为1表示使用，为0停止
     * @var
     */
    private $clWeek;

    /**
     * 清洗时间点设置
     * 格式HHmm  UTC时间
     * 表示每天清洗的时间点
     * @var string 长度4位
     */
    private $clTm;

    /**
     * 清洗时长设置
     * 单位： 秒
     * @var int
     */
    private $clDur;

    /**
     * 0：停止
     * 1：清洗中
     * 2：暂停中
     * 3：电机堵转故障
     * @var int
     */
    private $clState;

    /**
     * 清洗进度时间
     * 当前清洗过程已经历的时间
     * 单位：秒
     * @var integer
     */
    private $clSche;

    /**
     * 清洗设置
     * Bit0：清洗提示设置
     *      1使能，0禁止
     * Bit1：异常报警设置
     *      1使能，0禁止
     * @var integer
     */
    private $clCfg;

    /**
     * 杀菌灯开启时间
     * 格式HHmm，UTC时间
     * @var integer
     */
    private $uvOn;

    /**
     * 杀菌灯关闭时间    格式HHmm，UTC时间
     *
     * @var
     */
    private $uvOff;

    /**
     * 杀菌灯累计工作时间    单位小时
     * @var
     */
    private $uvWH;


    /**
     * 杀菌灯设置
     * Bit0：更换维护提示
     *  1使能，0禁止
     * Bit1：异常报警
     *  1使能，0禁止
     * @var int
     */
    private $uvCfg;

    /**
     * 备用插座A状态
     * 0：插座断电
     * 1：插座通电
     * @var
     */
    private $outStateA;

    /**
     * 备用插座B状态
     *    0：插座断电
     * 1：插座通电
     * @var
     */
    private $outStateB;
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

    private $oaPer;
    private $wsOnTm;
    private $wsOffTm;
    private $uvState;

    /**
     * @return mixed
     */
    public function getObPer()
    {
        return $this->obPer;
    }

    /**
     * @param mixed $obPer
     */
    public function setObPer($obPer)
    {
        $this->obPer = $obPer;
    }


    /**
     * @return mixed
     */
    public function getOaOnTm()
    {
        return $this->oaOnTm;
    }

    /**
     * @param mixed $oaOnTm
     */
    public function setOaOnTm($oaOnTm)
    {
        $this->oaOnTm = $oaOnTm;
    }

    /**
     * @return mixed
     */
    public function getOaOffTm()
    {
        return $this->oaOffTm;
    }

    /**
     * @param mixed $oaOffTm
     */
    public function setOaOffTm($oaOffTm)
    {
        $this->oaOffTm = $oaOffTm;
    }

    /**
     * @return mixed
     */
    public function getUvState()
    {
        return $this->uvState;
    }

    /**
     * @param mixed $uvState
     */
    public function setUvState($uvState)
    {
        $this->uvState = $uvState;
    }

    /**
     * @return mixed
     */
    public function getOaPer()
    {
        return $this->oaPer;
    }

    /**
     * @param mixed $oaPer
     */
    public function setOaPer($oaPer)
    {
        $this->oaPer = $oaPer;
    }

    /**
     * @return mixed
     */
    public function getWsOnTm()
    {
        return $this->wsOnTm;
    }

    /**
     * @param mixed $wsOnTm
     */
    public function setWsOnTm($wsOnTm)
    {
        $this->wsOnTm = $wsOnTm;
    }

    /**
     * @return mixed
     */
    public function getWsOffTm()
    {
        return $this->wsOffTm;
    }

    /**
     * @param mixed $wsOffTm
     */
    public function setWsOffTm($wsOffTm)
    {
        $this->wsOffTm = $wsOffTm;
    }

    /**
     * @return int
     */
    public function getClEn()
    {
        return $this->clEn;
    }

    /**
     * @param int $clEn
     */
    public function setClEn($clEn)
    {
        $this->clEn = $clEn;
    }

    /**
     * @return mixed
     */
    public function getClWeek()
    {
        return $this->clWeek;
    }

    /**
     * @param mixed $clWeek
     */
    public function setClWeek($clWeek)
    {
        if($clWeek == -1){
            $clWeek = 64;
        }
        $this->clWeek = $clWeek;
    }

    /**
     * @return string
     */
    public function getClTm()
    {
        return $this->clTm;
    }
    /**
     * @param string $clTm
     */
    public function setClTm($clTm)
    {
        $this->clTm = $clTm;
    }

    /**
     * @return int
     */
    public function getClDur()
    {
        return $this->clDur;
    }

    /**
     * @param int $clDur
     */
    public function setClDur($clDur)
    {
        if($clDur == -1){
            $clDur = 120;//默认清洗时间
        }
        $this->clDur = $clDur;
    }

    /**
     * @return int
     */
    public function getClState()
    {
        return $this->clState;
    }

    /**
     * @param int $clState
     */
    public function setClState($clState)
    {
        $this->clState = $clState;
    }

    /**
     * @return int
     */
    public function getClSche()
    {
        return $this->clSche;
    }

    /**
     * @param int $clSche
     */
    public function setClSche($clSche)
    {
        $this->clSche = $clSche;
    }

    /**
     * @return int
     */
    public function getClCfg()
    {
        return $this->clCfg;
    }

    /**
     * @param int $clCfg
     */
    public function setClCfg($clCfg)
    {
        $this->clCfg = $clCfg;
    }

    /**
     * @return int
     */
    public function getUvOn()
    {
        return $this->uvOn;
    }

    /**
     * @param int $uvOn
     */
    public function setUvOn($uvOn)
    {
        $this->uvOn = $uvOn;
    }

    /**
     * @return mixed
     */
    public function getUvOff()
    {
        return $this->uvOff;
    }

    /**
     * @param mixed $uvOff
     */
    public function setUvOff($uvOff)
    {
        $this->uvOff = $uvOff;
    }

    /**
     * @return mixed
     */
    public function getUvWH()
    {
        return $this->uvWH;
    }

    /**
     * @param mixed $uvWH
     */
    public function setUvWH($uvWH)
    {
        $this->uvWH = $uvWH;
    }

    /**
     * @return int
     */
    public function getUvCfg()
    {
        return $this->uvCfg;
    }

    /**
     * @param int $uvCfg
     */
    public function setUvCfg($uvCfg)
    {
        $this->uvCfg = $uvCfg;
    }

    /**
     * @return mixed
     */
    public function getOutStateA()
    {
        return $this->outStateA;
    }

    /**
     * @param mixed $outStateA
     */
    public function setOutStateA($outStateA)
    {
        $this->outStateA = $outStateA;
    }

    /**
     * @return mixed
     */
    public function getOutStateB()
    {
        return $this->outStateB;
    }

    /**
     * @param mixed $outStateB
     */
    public function setOutStateB($outStateB)
    {
        $this->outStateB = $outStateB;
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
//                return "缺少 " . $key . " 属性";
//            }
//        }
        return "";
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


}