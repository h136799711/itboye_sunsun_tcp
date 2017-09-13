<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\req;

use sunsun\filter_vat\consts\FilterVatRangeType;
use sunsun\po\BaseReqPo;

/**
 * Class FilterVatHbReq
 * 获取设备状态
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceInfoReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(FilterVatReqType::DeviceInfo);
        if (!empty($data)) {
            $this->setSn($data['sn']);
        }
        // 默认获取ABC参数
        $this->setRange(FilterVatRangeType::Range_ABC);

    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
            'range'=>$this->getRange()
        ];
    }

    /**
     * 0: A+B 类参数
     * 1: A+B+C 类参数
     * @return mixed
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     *
     * @param mixed $range
     */
    public function setRange($range)
    {
        $this->range = $range;
    }



    /**
     * @var
     * 响应参数范围
     * User: ${USER}
     * Date: ${DATE}
     * Time: ${TIME}
     */
    private $range;

}