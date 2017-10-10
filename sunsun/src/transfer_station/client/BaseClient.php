<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 11:13
 */

namespace sunsun\transfer_station\client;


use GatewayClient\Gateway;

class BaseClient
{
    protected function staticsDelay($sn,$client_id){
        // ============START 用于统计网络延时=========
        $session = Gateway::getSession($client_id);
        $delay = [];
        if(array_key_exists('delay',$session) && is_array($session['delay'])){
            $delay = $session['delay'];
        }

        if(count($delay) > 3) {
            array_pop($delay);
        }
        array_unshift($delay,['sn'=>$sn,'s'=>microtime(true)]);
        Gateway::updateSession($client_id,['delay'=>$delay]);
        // ============END  用于统计网络延时==========
    }

    protected function getSn(){
        $str = "".time().rand(0,1000);
        $str = substr($str,2,strlen($str));
        $sn =  intval($str);
        return $sn % 2147483648;
    }
}