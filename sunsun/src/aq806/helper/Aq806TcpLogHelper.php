<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 15:17
 */

namespace sunsun\aq806\helper;

use sunsun\aq806\dal\Aq806TcpLogDal;
use sunsun\aq806\model\Aq806TcpLogModel;

class Aq806TcpLogHelper
{
    public static function logDebug($client_id, $message, $type = 'debug')
    {
        self::log(null, $client_id, $message, $type);
    }

    public static function log($db, $client_id, $message, $type = 'common')
    {

        $dal = new Aq806TcpLogDal($db);
        $model = new  Aq806TcpLogModel();

        $model->setBody(json_encode($message));
        $model->setCreateTime(time());
        $model->setType($type);
        $model->setLevel(1);
        $model->setOwner($client_id);
        $dal->insert($model);
    }
}