<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\resp;


use sunsun\adt\req\AdtHbReq;
use sunsun\po\BaseRespPo;

/**
 * Class AdtHbReq
 * 心跳包
 * @package sunsun\adt\req
 */
class AdtHbResp extends BaseRespPo
{

    public function __construct(AdtHbReq $req = null)
    {
        $this->setRespType(AdtRespType::Heartbeat);
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn()
        ];
    }
}