<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 14:03
 */

namespace sunsun\server\business;


use sunsun\transfer_station\client\TransferClient;

class DebugHelper
{
    const HEBIDU_GROUP = 'hebidu';

    static $DebugDid = [];
    static $LastModifyTime = 0;

    const LOG_NOTHING = 0;
    const LOG_INFO = 1;
    const LOG_DEBUG = 2;
    const LOG_ERROR = 4;

    public static function logLoginDevice($message)
    {
        try {
            TransferClient::sendOriginMessageToGroup(self::HEBIDU_GROUP, $message);
        } catch (\Exception $exception) {

        }
    }

    public static function logLevel($session)
    {
        if (!empty($session) && array_key_exists('log_level', $session)) {
            $log_level = $session['log_level'];
            return $log_level;
        }
        return self::LOG_NOTHING;
    }

    public static function info($message, $session)
    {
        $log_level = self::logLevel($session);
        if (($log_level & self::LOG_INFO) === self::LOG_INFO) {
            self::sendToHebidu('[INFO] ' . $message);
        }
    }

    public static function error($message, $session = null)
    {
        if (is_null($session)) {
            self::sendToHebidu('[ERROR] ' . $message);
        } else {
            $log_level = self::logLevel($session);
            if (($log_level & self::LOG_ERROR) === self::LOG_ERROR) {
                self::sendToHebidu('[ERROR] ' . $message);
            }
        }
    }

    public static function debug($message, $session)
    {
        $log_level = self::logLevel($session);
        if (($log_level & self::LOG_DEBUG) === self::LOG_DEBUG) {
            self::sendToHebidu('[DEBUG] ' . $message);
        }
    }

    public static function sendToHebidu($message)
    {
        try {
            TransferClient::sendMessageToGroup(self::HEBIDU_GROUP, $message, date('Y-m-d H:i:s ', time()));
        } catch (\Exception $ex) {
            //不处理
        }
    }

    public static function readFile($filePath) {
        if (file_exists($filePath)) {
            // 本函数的结果会被缓存。
            $time = filemtime($filePath);
            if ($time != self::$LastModifyTime) {
                self::refreshDid(file_get_contents($path));
                self::$LastModifyTime = $time;
            }
            // 使用 clearstatcache() 清除缓存
            clearstatcache();
        }
    }

    /**
     * 刷新测试did, 多个did 逗号隔开
     * @param $debugDidStr
     */
    public static function refreshDid($debugDidStr) {
        $debugDidStr = trim($debugDidStr, ",");
        if (strpos($debugDidStr, ",") !== false) {
            self::$DebugDid = explode(",", $debugDidStr);
        } else {
            self::$DebugDid = [$debugDidStr];
        }
    }

    /**
     * 根据did 判断是否发送消息给设备
     * @param string $did
     * @param string $msg
     */
    public static function sendByDid($did, $msg) {
        if (in_array($did, self::$DebugDid)) {
            self::sendToHebidu($did.' '.$msg);
        }
    }
}