<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-11
 * Time: 13:46
 */

namespace sunsun\aq806\dal;


use sunsun\dal\BaseDal;
use sunsun\server\consts\DeviceType;
use sunsun\server\db\DbPool;

class Aq806BaseDal extends BaseDal
{
    public function __construct($db = null)
    {
        if($db == null){
            $db = DbPool::getInstance()->getDbByType(DeviceType::Did_AQ806);
        }
        parent::__construct($db);
    }
}