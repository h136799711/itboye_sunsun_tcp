<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-11
 * Time: 13:44
 */

namespace sunsun\adt\dal;


use sunsun\dal\BaseDal;
use sunsun\server\consts\DeviceType;
use sunsun\server\db\DbPool;

class AdtBaseDal extends BaseDal
{
    public function __construct($db = null)
    {
        if($db == null){
            $db = DbPool::getInstance()->getDbByType(DeviceType::Did_ADT);
        }
        parent::__construct($db);
    }
}