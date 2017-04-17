<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-20
 * Time: 11:14
 */

namespace sunsun\aq806\helper;


use sunsun\aq806\resp\Aq806CtrlDeviceResp;
use sunsun\aq806\resp\Aq806DeviceInfoResp;

class ModelConverterHelper
{
    public static function convertToModelArray(Aq806DeviceInfoResp $resp){
        $data = [];
        if(!is_null($resp->getT())){
            $data['t'] = $resp->getT();
        }
        if(!is_null($resp->getPwr())){
            $data['pwr'] = $resp->getPwr();
        }
        if(!is_null($resp->getTSet())){
            $data['t_set'] = $resp->getTSet();
        }
        if(!is_null($resp->getTCyc())){
            $data['t_cyc'] = $resp->getTCyc();
        }
        if(!is_null($resp->getCfg())){
            $data['cfg'] = $resp->getCfg();
        }

        if(!is_null($resp->getDevLock())){
            $data['dev_lock']  = $resp->getDevLock();
        }
        if(!is_null($resp->getUpdState()) && $resp->getUpdState() > -1){
            $data['upd_state'] = $resp->getUpdState();
        }else{
            $data['upd_state'] = 0;
        }

        return $data;
    }

    public static function convertToModelArrayOfCtrlDeviceResp(Aq806CtrlDeviceResp $resp){
        $data = [];
        if(!is_null($resp->getDevLock())){
            $data['dev_lock'] = $resp->getDevLock();
        }
        if(!is_null($resp->getTSet())) {
            $data['t_set'] = $resp->getTSet();
        }
        if(!is_null($resp->getTCyc())){
            $data['t_cyc']  = $resp->getTCyc();
        }
        if(!is_null($resp->getCfg())) {
            $data['cfg'] = $resp->getCfg();
        }
        if(!is_null($resp->getDevLock())){
            $data['dev_lock']  = $resp->getDevLock();
        }
        if(!is_null($resp->getUpdState()) && $resp->getUpdState() > -1){
            $data['upd_state']  = $resp->getUpdState();
        }else{
            $data['upd_state'] = 0;
        }

        return $data;
    }
}