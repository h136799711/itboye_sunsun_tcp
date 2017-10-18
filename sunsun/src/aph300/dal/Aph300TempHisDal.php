<?php

namespace sunsun\aph300\dal;

/**
 * Class Aph300TempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\aph300\dal
 */
class Aph300TempHisDal extends Aph300BaseDal
{
    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_aph300_temp_his");
    }
}