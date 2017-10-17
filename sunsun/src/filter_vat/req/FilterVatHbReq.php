<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\req;


use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * Class FilterVatHbReq
 * 心跳包
 * @package sunsun\filter_vat\req
 */
class FilterVatHbReq extends BaseHeartBeatClientReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FilterVatReqType::Heartbeat);
    }

}