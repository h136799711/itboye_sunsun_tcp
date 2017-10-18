<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class FilterVatHbReq
 * 设备事件
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceEventReq extends BaseDeviceEventClientReq
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FilterVatReqType::Event);
    }
}