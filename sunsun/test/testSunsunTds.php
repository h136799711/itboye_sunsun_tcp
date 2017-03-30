<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 15:42
 */
require_once __DIR__.'/../src/helper/Des.php';
require_once __DIR__.'/../src/decoder/SunsunTDS.php';
$data = [
    'reqType'=>"1",
    "sn"=>"0",
    "did"=>"10000001",
    "ver"=>"V1.0",
    "pwd"=>"gigw+DAcMITN4SuEe6JmkA==",
];
$pwd = "1234bcda";

$encodeText = \sunsun\decoder\SunsunTDS::encode($data,$pwd);
echo ($encodeText);