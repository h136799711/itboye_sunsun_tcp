<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 10:45
 */

namespace sunsun\server\req;


use sunsun\po\BaseReqPo;

/**
 * 设备发送过来的心跳请求
 * Class BaseHeartBeatClientReq
 * @package sunsun\server\req
 */
class BaseHeartBeatClientReq extends BaseReqPo
{
    public function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn()
        ];
    }
}