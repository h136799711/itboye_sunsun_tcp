<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\filter_vat\dal;

class FilterVatDeviceEventDal extends FilterVatBaseDal
{
    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_filter_vat_device_event");
    }
}