<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\heating_rod\dal;


use sunsun\heating_rod\model\HeatingRodDeviceEventModel;

class HeatingRodDeviceEventDal extends HeatingRodBaseDal
{
    protected $tableName = "sunsun_heating_rod_device_event";

    public function insert(HeatingRodDeviceEventModel $do)
    {
        return self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }


}