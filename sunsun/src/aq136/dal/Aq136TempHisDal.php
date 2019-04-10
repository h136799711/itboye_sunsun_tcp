<?php

namespace sunsun\aq136\dal;

/**
 * Class Aq136TempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\aq136\dal
 */
class Aq136TempHisDal extends Aq136BaseDal
{

    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_aq136_temp_his");
    }

}