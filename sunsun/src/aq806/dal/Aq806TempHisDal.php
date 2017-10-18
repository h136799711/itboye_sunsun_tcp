<?php

namespace sunsun\aq806\dal;

/**
 * Class Aq806TempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\aq806\dal
 */
class Aq806TempHisDal extends Aq806BaseDal
{

    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_aq806_temp_his");
    }

}