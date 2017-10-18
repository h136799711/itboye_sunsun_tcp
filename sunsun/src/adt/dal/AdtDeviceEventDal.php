<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\adt\dal;


use sunsun\adt\model\AdtDeviceEventModel;

class AdtDeviceEventDal extends AdtBaseDal
{
    protected $tableName = "sunsun_adt_device_event";

    public function insert(AdtDeviceEventModel $do)
    {
        return self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

}