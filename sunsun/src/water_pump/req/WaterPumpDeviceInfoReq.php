<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\water_pump\req;

use sunsun\po\BaseReqPo;

/**
 * Class WaterPumpHbReq
 * 获取设备状态
 * @package sunsun\water_pump\req
 */
class WaterPumpDeviceInfoReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(WaterPumpReqType::DeviceInfo);
        if (!empty($data)) {
            $this->setSn($data['sn']);
        }
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
        ];
    }


}