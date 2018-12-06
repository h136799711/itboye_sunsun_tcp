<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 13:33
 */

namespace sunsun\helper;


/**
 * DES
 * Class DesCrypt
 * @package app\vendor\Crypt
 */
class Des
{


    /**
     *加密
     * @param $value
     * @param $key
     * @return string <type>
     * @internal param $ <type> $value
     */
    public static function encrypt($value, $key)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $ret = openssl_encrypt($value, "des-ecb", $key);
        return $ret;
    }

    /**
     *解密
     * @param string $value base64加密过的密文
     * @param $key
     * @return string <type>
     * @internal param $ <type> $value
     */
    public static function decrypt($value, $key)
    {
        return openssl_decrypt($value, "des-ecb", $key);
    }

}