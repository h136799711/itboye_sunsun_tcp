<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-25
 * Time: 17:48
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\transfer_station\controller\RespMsgType;


class TransferClient
{
    private static function setRegisterAddr(){
        Gateway::$registerAddress = "101.37.37.167:1250";
    }
    /**
     * 获取分组内有多少个客户端链接
     * @param $did
     * @return bool
     */
    public static function totalClientByGroup($did){
        self::setRegisterAddr();
        return Gateway::getClientCountByGroup($did);
    }
    /**
     * 判断transfer通道是否有app在线
     * @param $did
     * @return bool
     */
    public static function hasAppOnline($did){
        self::setRegisterAddr();
        $cnt = Gateway::getClientCountByGroup($did);
        return $cnt > 0;
    }

    /**
     * 发送消息给群组
     * @param $group
     * @param $data
     * @param $sn
     */
    public static function sendMessageToGroup($group,$data,$sn){
        $ret['t'] = RespMsgType::Info;
        $ret['d'] = $data;
        $ret['sn'] = $sn;
        self::setRegisterAddr();
        Gateway::sendToGroup($group,json_encode($ret));
    }
}