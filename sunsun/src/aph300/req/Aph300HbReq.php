<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\req;


use sunsun\po\BaseReqPo;

/**
 * Class Aph300HbReq
 * 心跳包
 * @package sunsun\aph300\req
 */
class Aph300HbReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aph300ReqType::Heartbeat);
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
        ];
    }


}