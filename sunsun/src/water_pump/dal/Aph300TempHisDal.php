<?php

namespace sunsun\water_pump\dal;

use sunsun\water_pump\model\WaterPumpTempHisModel;
use sunsun\dal\BaseDal;

/**
 * Class WaterPumpTempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\water_pump\dal
 */
class WaterPumpTempHisDal extends BaseDal
{
    protected $tableName = "sunsun_water_pump_temp_his";

    public function insert(WaterPumpTempHisModel $do)
    {
        self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

    public function clearAll()
    {
        $this->truncateTable($this->tableName);
    }
}