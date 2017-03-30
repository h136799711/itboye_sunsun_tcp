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
 * 获取设备状态
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceInfoReq extends BaseReqPo
{

    public function __construct($data=null)
    {
        $this->setReqType(FilterVatReqType::DeviceInfo);
        if(!empty($data)){
            $this->setSn($data['sn']);
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