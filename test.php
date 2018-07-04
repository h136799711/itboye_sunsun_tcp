<?php
/**
 * Created by PhpStorm.
 * User: itboye
 * Date: 2018/5/26
 * Time: 11:49
 */

$did = "S01RS0000000035";
if (strpos($did, "S01RS000000") === false) {
    echo 'exit';
    exit;
}
$did = intval(str_replace("S01RS00000", "", $did));

if ($did > 1455) {
    echo 'exit';
    exit;
}

echo "update";

//(new \sunsun\filter_vat\dal\FilterVatDeviceDal())->updateByDid($did, ['update_rs'=>date("Y-m-d H:i:s")]);

//    exit;
//\sunsun\decoder\SunsunTDS::isLegalPwd("gP89BA8V0OBusxrqB4B0eg==", "7QHzqX5i");
$value = ("gP89BA8V0OBusxrqB4B0eg==");
var_dump($value);
$key = "1234a";
$decrypt = openssl_decrypt($value, "des-ecb", $key);

var_dump($decrypt);

$encrypt = openssl_encrypt("7QHzqX5i", "des-ecb", $key);

var_dump($encrypt);