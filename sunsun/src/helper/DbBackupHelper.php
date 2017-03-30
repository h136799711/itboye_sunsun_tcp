<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-18
 * Time: 18:53
 */

namespace sunsun\helper;


class DbBackupHelper
{

    /**
     * 同数据库备份
     * @param $tableName
     * @param $newTableName
     * @return string
     */
    public static function backupSql($tableName,$newTableName){
        $sql = "CREATE TABLE $newTableName LIKE $tableName";
        return $sql;
    }
}