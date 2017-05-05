<?php

namespace sunsun\dal;

use sunsun\model\LogModel;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class LogDal extends BaseDal
{
    protected $tableName = "sunsun_log";

    public function insert(LogModel $do)
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