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
class Des{


    /**
     *加密
     * @param $value
     * @param $key
     * @return string <type>
     * @internal param $ <type> $value
     */
    public static function encrypt ($value,$key)
    {
        $ret = base64_encode(openssl_encrypt($value,"des-ecb",$key));
        return $ret;
    }

    /**
     *解密
     * @param $value
     * @param $key
     * @return string <type>
     * @internal param $ <type> $value
     */
    public static function decrypt ($value,$key)
    {
        return openssl_decrypt(base64_decode($value),"des-ecb",$key);
    }

}