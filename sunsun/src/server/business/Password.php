<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 09:53
 */

namespace sunsun\server\business;

use GatewayWorker\Lib\Gateway;
use sunsun\server\consts\SessionKeys;

class Password
{
    const LOGIN_ENCRYPT_PASSWORD = '1234bcda';
    const TYPE_LOGIN = 1;
    const TYPE_OTHER = 2;

    /**
     * 获取加解密密钥
     * @param $type
     * @param $client_id
     * @return array|bool|string
     */
    public static function getSecretKey($type, $client_id)
    {
        if ($type == Password::TYPE_LOGIN) {
            return Password::LOGIN_ENCRYPT_PASSWORD;
        } else {
            $session = Gateway::getSession($client_id);
            if (!is_array($session)) {
                return false;
            }

            $result = false;
            if (array_key_exists(SessionKeys::DID, $session)) {
                $did = $session[SessionKeys::DID];
                if (array_key_exists(SessionKeys::PWD, $session)) {
                    $pwd = $session[SessionKeys::PWD];
                    $result = [SessionKeys::DID => $did, SessionKeys::PWD => $pwd];
                }
            }
            return $result;
        }
    }
}