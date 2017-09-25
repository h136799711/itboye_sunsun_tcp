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

Gateway::$registerAddress = "101.37.37.167:1250";

class TransferClient
{
    /**
     * 发送消息给群组
     * @param $group
     * @param $data
     * @param $sn
     */
    public function sendMessageToGroup($group,$data,$sn){
        $ret['t'] = RespMsgType::Info;
        $ret['d'] = $data;
        $ret['sn'] = $sn;
        Gateway::sendToGroup($group,json_encode($ret));
    }
}