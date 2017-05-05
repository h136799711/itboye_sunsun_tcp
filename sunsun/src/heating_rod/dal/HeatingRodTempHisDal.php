<?php

namespace sunsun\heating_rod\dal;

use sunsun\dal\BaseDal;
use sunsun\heating_rod\model\HeatingRodTempHisModel;

/**
 * Class HeatingRodTempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\heating_rod\dal
 */
class HeatingRodTempHisDal extends BaseDal
{
    protected $tableName = "sunsun_heating_rod_temp_his";

    public function insert(HeatingRodTempHisModel $do)
    {
        self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

    public function clearAll()
    {
        $this->truncateTable($this->tableName);
    }
}