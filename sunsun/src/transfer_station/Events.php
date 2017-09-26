<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-25
 * Time: 15:19
 */
namespace  sunsun\transfer_station\events;

use GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{

    /**
     * @var  \sunsun\server\db\DbPool
     */
    private static $dbPool;

    public static function onWorkerStart($businessWorker)
    {
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        Gateway::sendToClient($client_id,'connect '.$client_id);
    }


    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     */
    public static function onMessage($client_id, $message)
    {
        Gateway::sendToClient($client_id,'receive'.$message);
        return;
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        //3. tcp通道关闭
        Gateway::closeClient($client_id);
    }

    //============================帮助方法


}