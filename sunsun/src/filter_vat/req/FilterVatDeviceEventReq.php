<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\req;

use sunsun\po\BaseReqPo;

/**
 * Class FilterVatHbReq
 * 设备事件
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceEventReq extends BaseReqPo
{
    private $code;

    public function getCodeDesc(){
//        0：无操作
//1：杀菌灯更换维护提示
//2：杀菌灯异常报警（损坏）
//3：清洗开启
//4：清洗电机堵转异常
        //1. Language 多语言
        switch ($this->code){
            case 0:
                return "no action";
            case 1:
                return "Remind Sterilization lamp replacement maintenance ";
            case 2:
                return "Germicidal lamp abnormal alarm（Damaged）";
            case 3:
                return "Cleaning open";
            case 4:
                return "Cleaning motor abnormal rotation";
            default:break;
        }

        return "Unknown ";
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
        $this->setReqType(FilterVatReqType::Event);
        if(!empty($data)){
            $this->setSn($data['sn']);
            $this->setCode($data['code']);
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