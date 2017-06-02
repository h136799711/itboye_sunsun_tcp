<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 15:17
 */

namespace sunsun\water_pump\helper;

use sunsun\water_pump\dal\WaterPumpTcpLogDal;
use sunsun\water_pump\model\WaterPumpTcpLogModel;

class WaterPumpTcpLogHelper
{
    public static function logDebug($client_id, $message, $type = 'debug')
    {
        self::log(null, $client_id, $message, $type);
    }

    public static function log($db, $client_id, $message, $type = 'common')
    {

        $dal = new WaterPumpTcpLogDal($db);
        $model = new  WaterPumpTcpLogModel();

        $model->setBody(json_encode($message));
        $model->setCreateTime(time());
        $model->setType($type);
        $model->setLevel(1);
        $model->setOwner($client_id);
        $dal->insert($model);
    }
}