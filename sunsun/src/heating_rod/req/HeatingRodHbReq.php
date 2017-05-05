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
 * 心跳包
 * @package sunsun\heating_rod\req
 */
class HeatingRodHbReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(HeatingRodReqType::Heartbeat);
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