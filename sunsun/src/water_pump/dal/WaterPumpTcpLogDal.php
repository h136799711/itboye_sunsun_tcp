<?php

namespace sunsun\water_pump\dal;

use sunsun\water_pump\model\WaterPumpTcpLogModel;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class WaterPumpTcpLogDal extends WaterPumpBaseDal
{
    protected $tableName = "sunsun_water_pump_tcp_log";

    public function insert(WaterPumpTcpLogModel $do)
    {
        self::$db->insert($this->tableName)->cols(array(
            'owner' => $do->getOwner(),
            'body' => $do->getBody(),
            'level' => $do->getLevel(),
            'type' => $do->getType(),
            'create_time' => $do->getCreateTime()))->query();
    }

    public function clearAll()
    {
        $this->truncateTable($this->tableName);
    }
}