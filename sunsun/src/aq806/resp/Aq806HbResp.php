<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\resp;


use sunsun\aq806\req\Aq806HbReq;
use sunsun\po\BaseRespPo;

/**
 * Class Aq806HbReq
 * 心跳包
 * @package sunsun\aq806\req
 */
class Aq806HbResp extends BaseRespPo
{

    public function __construct(Aq806HbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(Aq806RespType::Heartbeat);
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn()
        ];
    }
}