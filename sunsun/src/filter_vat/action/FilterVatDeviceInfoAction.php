<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\filter_vat\action;


use GatewayWorker\Lib\Gateway;
use sunsun\filter_vat\dal\FilterVatDeviceDal;
use sunsun\filter_vat\helper\ModelConverterHelper;
use sunsun\filter_vat\resp\FilterVatDeviceInfoResp;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;

class FilterVatDeviceInfoAction
{
    public function updateInfo($did, $clientId, FilterVatDeviceInfoResp $resp)
    {
        $check = $resp->check();
        if (!empty($check)) {
            return ResultHelper::fail($check);
        }
        //更新设备信息
        $updateEntity = ModelConverterHelper::convertToModelArray($resp);
        $dal = new FilterVatDeviceDal();
        $avg = $this->logRespTime($clientId,$resp);
        if($avg > 12345679.999){
            $avg = 12345679.999;
        }
        $updateEntity['delay_avg'] = $avg;
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($updateEntity));

        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

    // 记录并统计最近几次的通信延时
    private function logRespTime($clientId,BaseRespPo $resp){
        $sn = $resp->getSn();
        $session = Gateway::getSession($clientId);
        if(!array_key_exists('delay',$session)){
            $session['delay'] = [];
        }else{
            $cnt = 5;//暂时统计次数
            $delay = $session['delay'];
            // 请求序号要相同，虽然有一定概率错误，但不影响
            $totalDelayMs = 0;
            $trueCnt = 0;
            foreach ($delay as $key=>&$vo) {
                if ($sn == $vo['sn']) {
                    $vo['d'] = microtime(true) - $vo['s'];
                }
                if($key >= $cnt) break;
                $trueCnt++;
                $totalDelayMs += (1000 * $vo['d']);
            }
            $delay['avg'] = $totalDelayMs / $trueCnt;
            // 暂定前5次获取设备信息的通信延时
            if(count($delay) > $cnt) {
                array_pop($delay);
            }
            Gateway::setSession($clientId,$session);
            return $delay['avg'];
        }

    }


}