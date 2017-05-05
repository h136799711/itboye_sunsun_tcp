<?php

namespace sunsun\aq806\dal;

use sunsun\aq806\model\Aq806TcpLogModel;
use sunsun\dal\BaseDal;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class Aq806TcpLogDal extends BaseDal
{
    protected $tableName = "sunsun_aq806_tcp_log";

    public function insert(Aq806TcpLogModel $do)
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