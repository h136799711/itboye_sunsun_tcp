<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-25
 * Time: 15:19
 */
namespace  sunsun\transfer_station\events;

date_default_timezone_set("Etc/GMT");

use GatewayWorker\Lib\Gateway;
use sunsun\consts\LogType;
use sunsun\helper\LogHelper;
use sunsun\server\db\DbPool;
use sunsun\transfer_station\controller\DeviceTransferCtrl;


/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Transfer
{

    /**
     * @var  \sunsun\server\db\DbPool
     */
    private static $dbPool;

    public static function onWorkerStart($businessWorker)
    {
//        self::$dbPool = DbPool::getInstance();
        //记录Worker启动信息
       // LogHelper::log(self::getDb(), $businessWorker->id, 'listen on 8299', 'transfer');
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
     //   LogHelper::log(self::getDb(), '$client_id', 'onConnect'.$client_id, 'transfer_on_connect');
        Gateway::sendToClient($client_id,($client_id));
    }


    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     */
    public static function onMessage($client_id, $message)
    {
//        try {
//
//            Gateway::sendToClient($client_id,'receive'.$message);
//            if (empty($message)) {
//                return;
//            }
//
//            $ctrl = new DeviceTransferCtrl();
//            $result = $ctrl->process($client_id,$message);
//            self::log($client_id,json_encode($result),'transfer');
//            if ($result['status']){
//               self::jsonSuc($client_id,'success',$result['info']);
//            }else{
//                self::jsonError($client_id, $result['info'], []);
//            }
//
//        } catch (\Exception $ex) {
//            self::jsonError($client_id, $ex->getMessage(), []);
//        }
//        return;
    }

    /**
     * 日志记录
     * @param string $client_id 通道编号
     * @param string $message 日志内容
     * @param string $type 日志类型
     */
    public static function log($client_id, $message, $type = 'common')
    {
//        LogHelper::log(self::getDb($client_id), $client_id, $message, 'server_' . $type);
    }

    //============================帮助方法

    /**
     * 获取数据库链接
     * @param $client_id
     * @return \sunsun\server\db\DbPool
     */
//    public static function getDb($client_id = '')
//    {
//        return self::$dbPool->getGlobalDb();
//    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        //3. tcp通道关闭
        Gateway::closeClient($client_id);
    }

    /**
     * 返回成功信息
     * @param $client_id
     * @param $msg
     * @param $data
     */
    private static function jsonSuc($client_id, $msg, $data)
    {
//        self::log($client_id, $msg, LogType::Error);
        Gateway::sendToClient($client_id,json_encode($data));
    }

    /**
     * 返回错误信息
     * @param $client_id
     * @param $msg
     * @param $data
     */
    private static function jsonError($client_id, $msg, $data)
    {
//        self::log($client_id, $msg, LogType::Error);
        Gateway::sendToClient($client_id,$msg);
//        Gateway::closeClient($client_id);
    }

    /**
     * 获取客服端ip
     * @return string
     */
//    private static function getClientIp()
//    {
//        if ($_SERVER && array_key_exists("REMOTE_ADDR", $_SERVER)) {
//            return $_SERVER['REMOTE_ADDR'];
//        }
//        return "";
//    }

}