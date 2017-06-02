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
 * 心跳包
 * @package sunsun\water_pump\req
 */
class WaterPumpHbReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(WaterPumpReqType::Heartbeat);
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