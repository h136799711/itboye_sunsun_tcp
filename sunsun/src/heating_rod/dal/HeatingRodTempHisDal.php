<?php

namespace sunsun\heating_rod\dal;

/**
 * Class HeatingRodTempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\heating_rod\dal
 */
class HeatingRodTempHisDal extends HeatingRodBaseDal
{
    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_heating_rod_temp_his");
    }
}