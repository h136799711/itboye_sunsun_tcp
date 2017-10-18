<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\resp;


use sunsun\filter_vat\req\FilterVatDeviceEventReq;
use sunsun\server\resp\BaseDeviceEventServerResp;

/**
 * Class FilterVatHbReq
 * 设备事件响应
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceEventResp extends BaseDeviceEventServerResp
{
    public function __construct(FilterVatDeviceEventReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FilterVatRespType::Event);
    }
}