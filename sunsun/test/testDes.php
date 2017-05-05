<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 15:42
 */
require_once __DIR__ . '/../src/helper/Des.php';
$text = "P:12345678";
$pwd = "12345678";
$demoEncode = "ltACiHjVjIkotGo4p6Jwkg==";
$methods = (openssl_get_cipher_methods());
//foreach ($methods as $item){
//    echo $item.'  ';
//}
$encodeText = \sunsun\helper\Des::decrypt(($demoEncode), $pwd);
echo ($encodeText) . ' || ';
$encodeText = \sunsun\helper\Des::encrypt($text, $pwd);
echo ($encodeText) . '    ';
$encodeText = \sunsun\helper\Des::decrypt(($encodeText), $pwd);
echo ($encodeText) . ' || ';