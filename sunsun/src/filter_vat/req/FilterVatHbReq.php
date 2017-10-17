<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\req;


use sunsun\po\BaseReqPo;

/**
 * Class FilterVatHbReq
 * 心跳包
 * @package sunsun\filter_vat\req
 */
class FilterVatHbReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FilterVatReqType::Heartbeat);
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
        ];
    }


}