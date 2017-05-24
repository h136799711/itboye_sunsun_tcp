<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\resp;


use sunsun\aph300\req\Aph300HbReq;
use sunsun\po\BaseRespPo;

/**
 * Class Aph300HbReq
 * 心跳包
 * @package sunsun\aph300\req
 */
class Aph300HbResp extends BaseRespPo
{

    public function __construct(Aph300HbReq $req = null)
    {
        $this->setRespType(Aph300RespType::Heartbeat);
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