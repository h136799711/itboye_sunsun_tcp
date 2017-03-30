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
     * @param <type> $value
     * @return <type>
     */
    public static function encrypt ($value,$key)
    {
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_ECB, '');
        $iv = substr($key,0,8);
        mcrypt_generic_init($td, $key, $iv);
        $value = self::PaddingPKCS7($value);
        $ret = base64_encode(mcrypt_generic($td, $value));
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $ret;
    }

    /**
     *解密
     * @param <type> $value
     * @return <type>
     */
    public static function decrypt ($value,$key)
    {
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_ECB, '');
        $iv = substr($key,0,8);
        mcrypt_generic_init($td, $key, $iv);
        $ret = trim(mdecrypt_generic($td, base64_decode($value)));
        $ret = self::UnPaddingPKCS7($ret);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $ret;
    }

    private static function PaddingPKCS7 ($data)
    {
        $block_size = mcrypt_get_block_size(MCRYPT_DES, 'ecb');
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char), $padding_char);
        return $data;
    }

    private static function UnPaddingPKCS7($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, - 1 * $pad);
    }
}