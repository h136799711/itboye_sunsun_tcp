<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\resp;

use sunsun\filter_vat\req\FilterVatLoginReq;
use sunsun\server\resp\BaseDeviceLoginServerResp;

class FilterVatLoginResp extends BaseDeviceLoginServerResp
{
    // construct
    public function __construct(FilterVatLoginReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FilterVatRespType::Login);
    }
}