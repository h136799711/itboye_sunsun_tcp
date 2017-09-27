<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-24
 * Time: 18:18
 */

namespace sunsun\helper;


use GatewayWorker\Lib\Gateway;
use sunsun\po\BaseRespPo;

class DevToServerDelayHelper
{

    // 记录并统计最近几次的通信延时
    public static  function logRespTime($clientId,BaseRespPo $resp){
        $sn = $resp->getSn();
        $session = Gateway::getSession($clientId);
        if(!array_key_exists('delay',$session)){
            $session['delay'] = [];
            return 0;
        }else{
            $cnt = 5;//暂时统计次数
            $delay = $session['delay'];
            // 请求序号要相同，虽然有一定概率错误，但不影响
            $totalDelayMs = 0;
            $trueCnt = 0;
            for ($key=0;$key<count($delay);$key++){
//            foreach ($delay as $key=>&$vo) {
                $vo = $session['delay'][$key];
                if(!array_key_exists('d',$vo)) {
                    $session['delay'][$key]['d'] = 0;
                }
                if ($sn == $vo['sn']) {
                    $vo['d'] = microtime(true);
                    $session['delay'][$key]['d'] = $vo['d'];
                }
                if($key >= $cnt) break;
                if(array_key_exists('d',$vo) && $vo['d'] > $vo['s']) {
                    $trueCnt++;
                    $totalDelayMs += (1000 * ($vo['d'] - $vo['s']));
                }
                $delay[$key] = $vo;
            }
            $delayAvg = 0;
            if($trueCnt > 0) {
                $delayAvg = $totalDelayMs / $trueCnt;
                $session['delay_avg'] = $delayAvg;
            }
            // 暂定前5次获取设备信息的通信延时
            if(count($delay) > $cnt) {
                array_pop($delay);
            }
            Gateway::setSession($clientId,$session);
            return $delayAvg;
        }

    }
}