<?php

namespace sunsun\aq118\dal;

/**
 * Class Aq118TempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\aq118\dal
 */
class Aq118TempHisDal extends Aq118BaseDal
{

    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_aq118_temp_his");
    }

}