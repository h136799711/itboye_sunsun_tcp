<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\cp1000\dal;

use sunsun\cp1000\model\Cp1000DeviceEventModel;

class Cp1000DeviceEventDal extends Cp1000BaseDal
{
    protected $tableName = "sunsun_cp1000_device_event";

    public function insert(Cp1000DeviceEventModel $do)
    {
        return self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }
}