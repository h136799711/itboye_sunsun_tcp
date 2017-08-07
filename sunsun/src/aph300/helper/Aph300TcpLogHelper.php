<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 15:17
 */

namespace sunsun\aph300\helper;

use sunsun\aph300\dal\Aph300TcpLogDal;
use sunsun\aph300\model\Aph300TcpLogModel;

class Aph300TcpLogHelper
{
    public static function logDebug($client_id, $message, $type = 'debug')
    {
        self::log(null, $client_id, $message, $type);
    }

    public static function log($db, $client_id, $message, $type = 'common')
    {

        if(defined('SUNSUN_ENV') && SUNSUN_ENV == 'debug') {
            $dal = new Aph300TcpLogDal($db);
            $model = new  Aph300TcpLogModel();

            $model->setBody(json_encode($message));
            $model->setCreateTime(time());
            $model->setType($type);
            $model->setLevel(1);
            $model->setOwner($client_id);
            $dal->insert($model);
        }
    }
}