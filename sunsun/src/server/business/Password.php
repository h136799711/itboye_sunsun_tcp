<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 09:53
 */

namespace sunsun\server\business;

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

            $result = false;
            if (is_array($_SESSION) && array_key_exists(SessionKeys::DID, $_SESSION) && array_key_exists(SessionKeys::PWD, $_SESSION)) {
                $did = $_SESSION[SessionKeys::DID];
                $pwd = $_SESSION[SessionKeys::PWD];
                $result = [SessionKeys::DID => $did, SessionKeys::PWD => $pwd];
            }
            return $result;
        }
    }
}