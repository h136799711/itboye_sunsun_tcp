<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-11
 * Time: 13:47
 */

namespace sunsun\filter_vat\dal;

use sunsun\server\consts\DeviceType;
use sunsun\server\db\DbPool;
use sunsun\server\interfaces\BaseDalV2;

class FilterVatBaseDal extends BaseDalV2
{

    public function __construct($db = null)
    {
        if($db == null){
            $db = DbPool::getInstance()->getDbByType(DeviceType::Did_FilterVat);
        }
        parent::__construct($db);
    }

}