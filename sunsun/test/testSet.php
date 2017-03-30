<?php

require_once __DIR__ . '/../../vendor/autoload.php';
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-20
 * Time: 15:43
 */
function log2($msg){
    echo $msg;
}
echo "test";
$data = [
    'sn'=>"1",
];
if(array_key_exists("sn",$data)){
    echo "array_key_exists sn";
}
array_key_exists("sn",$data) && log2("test".($data['sn']));
$json = '{"resType":3,"sn":"1","clEn":"1","clWeek":"1","clTm":"1200","clDur":"1","clState":"3","clSche":"1","clCfg":"1","uvOn":"1300","uvOff":"1400","uvWH":"1","uvCfg":"1","outStateA":"1","outStateB":"1","devLock":"1","updState":0}';
$resp = new \sunsun\filter_vat\resp\FilterVatDeviceInfoResp();
$resp->setData(json_decode($json,JSON_OBJECT_AS_ARRAY));
var_dump(\sunun\filter_vat\helper\ModelConverterHelper::convertToModelArray($resp));