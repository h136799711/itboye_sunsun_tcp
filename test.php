<?php
/**
 * Created by PhpStorm.
 * User: itboye
 * Date: 2018/5/26
 * Time: 11:49
 */
require_once "./vendor/autoload.php";

var_dump(unpack("n", pack("n", 255*255)));

$encodeData = "TV9E7pWVziw=";

function calSum($str)
{
    $sum = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $one =  substr($str, $i, 1);
        $sum += ord($one);
    }
    return $sum;
}

$encode = \sunsun\decoder\SunsunTDS::encode("hello", "12345678");
$decode = \sunsun\SunsunV1::decode($encode);
var_dump($decode);
$encodeV1 = \sunsun\SunsunV1::encode($decode);
var_dump($encode === $encodeV1);
