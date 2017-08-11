<?php

namespace sunsun\aph300\dal;

use sunsun\aph300\model\Aph300TempHisModel;
use sunsun\dal\BaseDal;

/**
 * Class Aph300TempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\aph300\dal
 */
class Aph300TempHisDal extends Aph300BaseDal
{
    protected $tableName = "sunsun_aph300_temp_his";

    public function insert(Aph300TempHisModel $do)
    {
        self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

    public function clearAll()
    {
        $this->truncateTable($this->tableName);
    }
}