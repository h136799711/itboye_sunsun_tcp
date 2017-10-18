<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\aq806\dal;

class Aq806DeviceEventDal extends Aq806BaseDal
{
    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_aq806_device_event");
    }

}