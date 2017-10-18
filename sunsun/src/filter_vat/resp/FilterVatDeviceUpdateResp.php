<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\resp;

use sunsun\filter_vat\req\FilterVatDeviceUpdateReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;

/**
 * Class FilterVatHbReq
 * 心跳包
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceUpdateResp extends BaseDeviceFirmwareUpdateClientResp
{
    public function __construct(FilterVatDeviceUpdateReq $req = null)
    {
        parent::__construct($req);
        $this->setRespType(FilterVatRespType::FirmwareUpdate);
    }
}