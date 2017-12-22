<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 15:42
 */
require_once __DIR__ . '/../src/helper/Des.php';
require_once __DIR__ . '/../src/decoder/SunsunTDS.php';
require_once __DIR__ . '/../src/po/TdsPo.php';

function toStringData($data)
{
    if (is_array($data)) {
        foreach ($data as $key => &$value) {
            $data[$key] = toStringData($value);
        }
    } elseif (!is_object($data) && !is_string($data)) {
        return strval($data);
    }

    return $data;
}

$str = "{\"resType\":\"101\",\"sn\":\"971\",\"state\":\"0\",\"tm\":\"20171222053120\",\"hb\":\"120\"}";

$data = json_decode($str, JSON_OBJECT_AS_ARRAY);
$data = toStringData($data);
$pwd = "1234bcda";


$encodeText = \sunsun\decoder\SunsunTDS::encode($data, $pwd);
var_dump(serialize($encodeText));
$encrypt = $encodeText;
//$encrypt = "";

//$encrypt = base64_decode($encrypt);
$encodeText = \sunsun\decoder\SunsunTDS::decode($encrypt, $pwd);
var_dump($encodeText->getTdsOriginData());

//
//$data = [
//    'reqType' => "1",
//    "sn" => "0",
//    "did" => "10000001",
//    "ver" => "V1.0",
//    "pwd" => "gigw+DAcMITN4SuEe6JmkA==",
//];
//$pwd = "1234bcda";
//
//$encodeText = \sunsun\decoder\SunsunTDS::encode($data, $pwd);
//echo($encodeText);