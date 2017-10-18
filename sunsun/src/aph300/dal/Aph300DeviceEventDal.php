<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\aph300\dal;

use sunsun\aph300\model\Aph300DeviceEventModel;

class Aph300DeviceEventDal extends Aph300BaseDal
{
    protected $tableName = "sunsun_aph300_device_event";

    public function insert(Aph300DeviceEventModel $do)
    {
        return self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

}