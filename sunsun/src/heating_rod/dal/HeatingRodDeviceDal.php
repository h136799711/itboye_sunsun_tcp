<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\heating_rod\dal;

class HeatingRodDeviceDal extends HeatingRodBaseDal
{
    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_heating_rod_device");
    }
}