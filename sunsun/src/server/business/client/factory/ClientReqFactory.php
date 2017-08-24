<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-24
 * Time: 15:53
 */

namespace sunsun\server\business\client\factory;


use sunsun\server\business\client\po\ReqTypes;

class ClientReqFactory
{
    public static function create($json){
        if(!array_key_exists('type', $json)){
            return null;
        }
        $type = $json['type'];
        switch ($type){
            case ReqTypes::Login:
                break;
            default:break;
        }
    }
}