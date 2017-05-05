<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\aq806\dal;


use sunsun\dal\BaseDal;
use sunsun\aq806\model\Aq806DeviceEventModel;
use sunsun\aq806\model\Aq806DeviceModel;
use sunsun\helper\DbBackupHelper;

class Aq806DeviceEventDal extends BaseDal
{
    protected $tableName = "sunsun_aq806_device_event";

    public function insert(Aq806DeviceEventModel $do){
        return self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

    /**
     * 备份
     * 备份规则如下：
     * 每月备份一次
     */
    public function backup(){
        $firstDay = date("Y-m-01",time());
        $lastYm = date("Ym",strtotime($firstDay)-1);
        $dataTimestamp = strtotime($firstDay);
        $newTableName = $this->tableName.'_'.$lastYm;
        $sql = DbBackupHelper::backupSql($this->tableName,$newTableName);

        try{
            self::$db->beginTrans();
            $result = $this->isTableExist($newTableName);
            if($result){
                var_dump($result);
            }
            //2. 数据迁移到新表
            $sql .= ";INSERT INTO ".$newTableName.' SELECT * FROM '.$this->tableName;
            $sql.= "WHERE create_time < ".$dataTimestamp;

//            $result = self::$db->query($sql);
            //3. 删除旧数据
            $sql .= ";DELETE FROM ".$this->tableName ." WHERE create_time < ".$dataTimestamp;
            $result = self::$db->query($sql);
            if($result){
                self::$db->commitTrans();
            }else{
                self::$db->rollBackTrans();
            }
        }catch (\Exception $exception){
            self::$db->rollBackTrans();
        }

    }

}