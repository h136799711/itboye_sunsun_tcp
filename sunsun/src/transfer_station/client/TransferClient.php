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
        Gateway::$registerAddress = "172.16.23.85:1250";
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
     * @param string $type
     */
    public static function sendMessageToGroup($group, $data, $sn, $type = RespMsgType::Info)
    {
        $ret['t'] = $type;
        $ret['d'] = $data;
        $ret['sn'] = $sn;
        $ret['group'] = $group;
        self::setRegisterAddr();
        Gateway::sendToGroup($group,json_encode($ret));
    }

    /**
     * 发送原始消息
     * @param $group
     * @param $data
     */
    public static function sendOriginMessageToGroup($group, $data)
    {
        self::setRegisterAddr();
        Gateway::sendToGroup($group, json_encode($data));
    }
}