<?php


date_default_timezone_set("Etc/GMT");

use GatewayWorker\Lib\Gateway;
use sunsun\transfer_station\controller\DeviceTransferCtrl;


/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{


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
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     */
    public static function onMessage($client_id, $message)
    {
        try {

            if (empty($message)) {
                return;
            }

            $ctrl = new DeviceTransferCtrl();
            $result = $ctrl->process($client_id,$message);
//            self::log($client_id,json_encode($result),'transfer');
            Gateway::sendToClient($client_id,json_encode($result));
            if($result['code'] != 0){
                Gateway::closeClient($client_id);
            }
        } catch (\Exception $ex) {
            Gateway::sendToClient($client_id,$ex->getMessage());
            Gateway::closeClient($client_id);
        }
        return;
    }

    //============================帮助方法


    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        //3. tcp通道关闭
        Gateway::closeClient($client_id);
    }

}