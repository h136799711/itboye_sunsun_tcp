<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\filter_vat\dal;


use sunsun\filter_vat\model\FilterVatDeviceEventModel;

class FilterVatDeviceEventDal extends FilterVatBaseDal
{
    protected $tableName = "sunsun_filter_vat_device_event";

    public function insert(FilterVatDeviceEventModel $do)
    {
        return self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

}