<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\water_pump\action;


use GatewayWorker\Lib\Gateway;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\interfaces\BaseAction;
use sunsun\server\req\BaseHeartBeatClientReq;


/**
 * Class WaterPumpHbAction
 * 心跳包处理
 * @package sunsun\water_pump\action
 */
class WaterPumpHbAction extends BaseAction
{
    /**
     * 心跳计数最大 - 例如等于2 则每2次心跳才更新一次数据库
     * 0 < 心跳次数  < 720 / 心跳间隔时间（默认是120） 这个是离线检测的时间
     * 查看
     * itboye_sunsunxiaoli项目的
     * app\index\helper\CommandHelper::offline_notify 中的定义
     */
    const HB_COUNT_MAX = 2;

    public function deviceHeartBeat($did, $clientId, BaseHeartBeatClientReq $req)
    {
        $session = Gateway::getSession($clientId);
        $hbCnt = 1;

        if ($session && array_key_exists('hb_cnt', $session)) {
            $hbCnt = intval($session['hb_cnt']);
            if ($hbCnt < self::HB_COUNT_MAX) {
                (DeviceFacadeFactory::getDeviceDal($did))->updateByDid($did, ['update_time' => time()]);
                $hbCnt++;
            } else {
                $hbCnt = 1;
            }
        }

        Gateway::updateSession($clientId, ['hb_cnt' => $hbCnt]);

        $respObj = RespFacadeFactory::createHeartBeatRespObj($did, $req);
        return $respObj;
    }
}