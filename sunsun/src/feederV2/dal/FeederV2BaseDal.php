<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-11
 * Time: 13:19
 */

namespace sunsun\feederV2\dal;


use sunsun\server\consts\DeviceType;
use sunsun\server\db\DbPool;
use sunsun\server\interfaces\BaseDalV2;

class FeederV2BaseDal extends BaseDalV2
{
    public function __construct($db = null)
    {
        if ($db == null) {
            $db = DbPool::getInstance()->getDbByType(DeviceType::Did_FeederV2);
        }
        parent::__construct($db);
    }
}