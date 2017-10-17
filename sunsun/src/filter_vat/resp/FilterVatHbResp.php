<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\resp;


use sunsun\filter_vat\req\FilterVatHbReq;
use sunsun\po\BaseRespPo;

/**
 * Class FilterVatHbReq
 * 心跳包
 * @package sunsun\filter_vat\req
 */
class FilterVatHbResp extends BaseRespPo
{

    public function __construct(FilterVatHbReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FilterVatRespType::Heartbeat);
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn()
        ];
    }
}