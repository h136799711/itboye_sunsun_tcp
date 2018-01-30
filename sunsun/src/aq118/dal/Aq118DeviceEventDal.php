<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\aq118\dal;

class Aq118DeviceEventDal extends Aq118BaseDal
{
    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_aq118_device_event");
    }

}