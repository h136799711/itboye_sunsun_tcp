<?php

namespace sunsun\heating_rod\dal;

use sunsun\heating_rod\model\HeatingRodTcpLogModel;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class HeatingRodTcpLogDal extends HeatingRodBaseDal
{
    protected $tableName = "sunsun_heating_rod_tcp_log";

    public function insert(HeatingRodTcpLogModel $do)
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