<?php
/**
 * Created by PhpStorm.
 * User: itboye
 * Date: 2018/5/26
 * Time: 11:49
 */

$value = base64_decode("gP89BA8V0OBusxrqB4B0eg==");
var_dump($value);
$key = "7QHzqX5i";
$decrypt = openssl_decrypt($value, "des-ecb", $key);

var_dump($decrypt);

$encrypt = openssl_encrypt("7QHzqX5i", "des-ecb", $key);

var_dump($encrypt);