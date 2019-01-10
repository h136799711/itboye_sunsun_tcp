<?php

namespace sunsun\hwfish\dal;

/**
 * Class HwfishTempHisDal
 * @author hebidu <email:346551990@qq.com>
 * @package sunsun\hwfish\dal
 */
class HwfishTempHisDal extends HwfishBaseDal
{

    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_hwfish_temp_his");
    }

}