<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\aq806\dal;


use sunsun\aq806\model\Aq806DeviceEventModel;

class Aq806DeviceEventDal extends Aq806BaseDal
{
    protected $tableName = "sunsun_aq806_device_event";

    public function insert(Aq806DeviceEventModel $do)
    {
        return self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

}