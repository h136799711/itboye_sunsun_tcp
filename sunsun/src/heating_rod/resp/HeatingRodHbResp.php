<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\resp;


use sunsun\heating_rod\req\HeatingRodHbReq;
use sunsun\po\BaseRespPo;

/**
 * Class HeatingRodHbReq
 * 心跳包
 * @package sunsun\heating_rod\req
 */
class HeatingRodHbResp extends BaseRespPo
{

    public function __construct(HeatingRodHbReq $req=null)
    {
        $this->setRespType(HeatingRodRespType::Heartbeat);
        if(!empty($req)){
            $this->setSn($req->getSn());
        }
    }

    public function toDataArray()
    {
        return [
            'resType'=>$this->getRespType(),
            'sn'=>$this->getSn()
        ];
    }
}