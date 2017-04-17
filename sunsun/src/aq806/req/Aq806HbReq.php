<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\req;


use sunsun\po\BaseReqPo;

/**
 * Class Aq806HbReq
 * 心跳包
 * @package sunsun\aq806\req
 */
class Aq806HbReq extends BaseReqPo
{

    public function __construct($data=null)
    {
        $this->setReqType(Aq806ReqType::Heartbeat);
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