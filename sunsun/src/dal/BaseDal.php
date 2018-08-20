<?php
// 自动加载类

namespace sunsun\dal;

use sunsun\server\business\Events;
use sunsun\server\db\DbPool;
use Workerman\MySQL;


/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class BaseDal
{
    /**
     * @var MySQL\Connection
     *
     * User: ${USER}
     * Date: ${DATE}
     * Time: ${TIME}
     */
    public static $db;

    public function __construct($db = null)
    {
        if ($db instanceof MySQL\Connection) {
            self::$db = $db;
        } else
            if (!(self::$db instanceof MySQL\Connection)) {
                if(property_exists('\sunsun\server\business\Events','db')){
                    self::$db = Events::$db;
                }
                elseif(property_exists('Events','db')){
                    self::$db = \Events::$db;
                } else {
                    self::$db = DbPool::getInstance()->getGlobalDb();
                }
            }
    }

    public function truncateTable($tableName)
    {
        return self::$db->query("TRUNCATE TABLE " . $tableName);
    }

    public function getLastSql()
    {
        return self::$db->lastSQL();
    }

    public function isTableExist($tableName)
    {
        return self::$db->query("select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA = '" . SUNSUN_WORKER_DB_NAME . "' and TABLE_NAME='$tableName' ");
    }
}