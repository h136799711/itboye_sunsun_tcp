<?php

namespace sunsun\adt\dal;

use sunsun\adt\model\AdtTcpLogModel;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class AdtTcpLogDal extends AdtBaseDal
{
    protected $tableName = "sunsun_adt_tcp_log";

    public function insert(AdtTcpLogModel $do)
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