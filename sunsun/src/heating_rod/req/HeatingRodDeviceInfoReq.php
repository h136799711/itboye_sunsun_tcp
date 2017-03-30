<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\req;

use sunsun\po\BaseReqPo;

/**
 * Class HeatingRodHbReq
 * 获取设备状态
 * @package sunsun\heating_rod\req
 */
class HeatingRodDeviceInfoReq extends BaseReqPo
{

    public function __construct($data=null)
    {
        $this->setReqType(HeatingRodReqType::DeviceInfo);
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