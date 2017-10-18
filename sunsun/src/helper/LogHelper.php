<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 15:17
 */

namespace sunsun\helper;


use sunsun\dal\LogDal;
use sunsun\model\LogModel;

class LogHelper
{
    public static function debug($did, $client_id, $message, $type = 'debug')
    {

    }
    public static function logDebug($client_id, $message, $type = 'debug')
    {
        self::log(null, $client_id, $message, $type);
    }

    public static function log($db, $client_id, $message, $type = 'common')
    {

        if($type == 'error' || ((defined('SUNSUN_ENV') && SUNSUN_ENV == 'debug'))) {
            $dal = new LogDal($db);
            $model = new  LogModel();

            $model->setBody(json_encode($message));
            $model->setCreateTime(time());
            $model->setType($type);
            $model->setLevel(1);
            $model->setOwner($client_id);
            $dal->insert($model);
        }
    }
}