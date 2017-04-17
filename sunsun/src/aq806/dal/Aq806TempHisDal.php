<?php

namespace sunsun\aq806\dal;

use sunsun\dal\BaseDal;
use sunsun\aq806\model\Aq806TempHisModel;

/**
 * Class Aq806TempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\aq806\dal
 */
class Aq806TempHisDal extends BaseDal
{
    protected $tableName = "sunsun_aq806_temp_his";

    public function insert(Aq806TempHisModel $do){
        self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

    public function clearAll(){
        $this->truncateTable($this->tableName);
    }
}