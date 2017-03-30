<?php
// 自动加载类

namespace sunsun\dal;

use Workerman\MySQL;


/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class BaseDal
{
    public static  $db;
    public function __construct($db = null){
        if($db instanceof MySQL\Connection){
            self::$db = $db;
        }else
        if(!(self::$db instanceof  MySQL\Connection)){
            $db = \Events::$db;
            if($db != null){
                $db = \Events::$db;
            }else{
            self::$db = new \Workerman\MySQL\Connection(SUNSUN_WORKER_HOST, SUNSUN_WORKER_PORT, SUNSUN_WORKER_USER, SUNSUN_WORKER_PASSWORD, SUNSUN_WORKER_DB_NAME);
            }
        }
    }

    public function truncateTable($tableName){
        return self::$db->query("TRUNCATE TABLE ".$tableName);
    }

    public function getLastSql(){
        return self::$db->lastSQL();
    }

    public function isTableExist($tableName){
        return self::$db->query("select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA = '".SUNSUN_WORKER_DB_NAME."' and TABLE_NAME='$tableName' ");
    }
}