<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 11:21
 */

namespace sunsun\server\req;


use sunsun\po\BaseReqPo;

abstract class BaseDeviceInfoServerReq extends BaseReqPo
{
    public function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
        ];
    }
}