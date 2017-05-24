<?php

namespace sunsun\aph300\dal;

use sunsun\aph300\model\Aph300TcpLogModel;
use sunsun\dal\BaseDal;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class Aph300TcpLogDal extends BaseDal
{
    protected $tableName = "sunsun_aph300_tcp_log";

    public function insert(Aph300TcpLogModel $do)
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