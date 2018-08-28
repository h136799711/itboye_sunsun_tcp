<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 15:17
 */

namespace sunsun\helper;


use sunsun\model\LogModel;
use Workerman\Worker;

class LogHelper
{
    public static function debug($did, $client_id, $message, $type = 'debug')
    {

    }
    public static function logDebug($client_id, $message, $type = 'debug')
    {
        self::log(null, $client_id, $message, $type);
    }

    public static function log($db, $client_id, $message, $type = 'common', $remoteIp = '', $remotePort = '', $gatewayIp = '', $gatewayPort = '')
    {

        if($type == 'error' || ((defined('SUNSUN_ENV') && SUNSUN_ENV == 'debug'))) {
//            $dal = new LogDal($db);
            $model = new  LogModel();
            $model->setRemotePort($remotePort);
            $model->setGatewayIp($gatewayIp);
            $model->setGatewayPort($gatewayPort);
            $model->setRemoteIp($remoteIp);
            $model->setBody(json_encode($message));
            $model->setCreateTime(time());
            $model->setType($type);
            $model->setLevel(1);
            $model->setOwner($client_id);
            $info = json_encode($model->toDataArray(), JSON_OBJECT_AS_ARRAY);
            Worker::log($info);
        }
    }
}