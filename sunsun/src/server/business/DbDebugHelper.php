<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 14:03
 */

namespace sunsun\server\business;


use sunsun\transfer_station\client\TransferClient;

class DbDebugHelper
{


    public static function info($message, $session)
    {

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

    public static function sendToHebidu($message)
    {
        try {
            TransferClient::sendMessageToGroup(self::HEBIDU_GROUP, $message, date('Y-m-d H:i:s ', time()));
        } catch (\Exception $ex) {
            //不处理
        }
    }

    public static function debug($message, $session)
    {
        $log_level = self::logLevel($session);
        if (($log_level & self::LOG_DEBUG) === self::LOG_DEBUG) {
            self::sendToHebidu('[DEBUG] ' . $message);
        }
    }
}