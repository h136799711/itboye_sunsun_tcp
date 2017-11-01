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
            $cnt = 3;//暂时统计次数
            $delay = $session['delay'];
            // 请求序号要相同，虽然有一定概率错误，但不影响
            $totalDelayMs = 0;
            $trueCnt = 0;
            for ($key=0;$key < count($delay);$key++){
                $vo = $delay[$key];
                if(!array_key_exists('d',$vo)) {
                    $vo['d'] = 0;
                }
                if ($sn == $vo['sn']) {
                    $vo['d'] = microtime(true);
                }
                if ($vo['d'] > $vo['s']) {
                    $trueCnt++;
                    $totalDelayMs += (1000 * ($vo['d'] - $vo['s']));
                }
            }
            $delayAvg = 0;
            if($trueCnt > 0) {
                $delayAvg = $totalDelayMs / $trueCnt;
            }
            // 暂定前5次获取设备信息的通信延时
            if(count($delay) > $cnt) {
                array_pop($delay);
            }
            Gateway::updateSession($clientId,['delay'=>$delay, 'delay_avg'=>$delayAvg]);
            return $delayAvg;
        }

    }


    public static function start($sn, $client_id)
    {
        // ============START 用于统计网络延时=========
        $session = Gateway::getSession($client_id);
        $delay = [];
        if (array_key_exists('delay', $session) && is_array($session['delay'])) {
            $delay = $session['delay'];
        }

        // 操作频繁的情况下会将未响应的移除掉，所以这里设置比统计的3个大
        if (count($delay) > 20) {
            array_pop($delay);
        }
        array_unshift($delay, ['sn' => $sn, 's' => microtime(true)]);
        Gateway::updateSession($client_id, ['delay' => $delay]);
        // ============END  用于统计网络延时==========
    }
}