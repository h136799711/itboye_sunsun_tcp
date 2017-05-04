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
        if(!is_null($resp->getPh())){
            $data['ph'] = $resp->getPh();
        }
        if(!is_null($resp->getOut())){
            $data['out_ctrl'] = $resp->getOut();
        }
        if(!is_null($resp->getTMax())){
            $data['t_max'] = $resp->getTMax();
        }
        if(!is_null($resp->getFault())){
            $data['fault'] = $resp->getFault();
        }
        if(!is_null($resp->getTh())){
            $data['th'] = $resp->getTh();
        }
        if(!is_null($resp->getTl())){
            $data['tl'] = $resp->getTl();
        }
        if(!is_null($resp->getPP())){
            $data['p_p'] = $resp->getPP();
        }
        if(!is_null($resp->getUvcP())){
            $data['uvc_p'] = $resp->getUvcP();
        }
        if(!is_null($resp->getSpP())){
            $data['sp_p'] = $resp->getSpP();
        }
        if(!is_null($resp->getLP())){
            $data['l_p'] = $resp->getLP();
        }
        if(!is_null($resp->getLPer())){
            $data['l_per'] = $resp->getLPer();
            if(is_array($data['l_per'])){
                $data['l_per'] = json_encode($data['l_per']);
            }
        }
        if(!is_null($resp->getUvcPer())){
            $data['uvc_per'] = $resp->getUvcPer();
            if(is_array($data['uvc_per'])){
                $data['uvc_per'] = json_encode($data['uvc_per']);
            }
        }
        if(!is_null($resp->getSpPer())){
            $data['sp_per'] = $resp->getSpPer();
            if(is_array($data['sp_per'])){
                $data['sp_per'] = json_encode($data['sp_per']);
            }
        }
        if(!is_null($resp->getExDev())){
            $data['exDev'] = $resp->getExDev();
        }

        if(!is_null($resp->getDevLock())){
            $data['dev_lock']  = $resp->getDevLock();
        }
        if(!is_null($resp->getUpdState()) && $resp->getUpdState() > -1){
            $data['upd_state'] = $resp->getUpdState();
        }else{
            $data['upd_state'] = 0;
        }


        if(!is_null($resp->getPushCfg())){
            $data['push_cfg']  = $resp->getPushCfg();
        }

        if(!is_null($resp->getDCyc())){
            $data['d_cyc']  = $resp->getDCyc();
        }

        if(!is_null($resp->getUvWh())){
            $data['uv_wh']  = $resp->getUvWh();
        }

        if(!is_null($resp->getPWh())){
            $data['p_wh']  = $resp->getPWh();
        }

        if(!is_null($resp->getLWh())){
            $data['l_wh']  = $resp->getLWh();
        }
        return $data;
    }

    public static function convertToModelArrayOfCtrlDeviceResp(Aq806CtrlDeviceResp $resp){
        $data = [];

        if(!is_null($resp->getT())){
            $data['t'] = $resp->getT();
        }
        if(!is_null($resp->getPh())){
            $data['ph'] = $resp->getPh();
        }
        if(!is_null($resp->getOut())){
            $data['out_ctrl'] = $resp->getOut();
        }
        if(!is_null($resp->getTMax())){
            $data['t_max'] = $resp->getTMax();
        }
        if(!is_null($resp->getFault())){
            $data['fault'] = $resp->getFault();
        }
        if(!is_null($resp->getTh())){
            $data['th'] = $resp->getTh();
        }
        if(!is_null($resp->getTl())){
            $data['tl'] = $resp->getTl();
        }
        if(!is_null($resp->getPP())){
            $data['p_p'] = $resp->getPP();
        }
        if(!is_null($resp->getUvcP())){
            $data['uvc_p'] = $resp->getUvcP();
        }
        if(!is_null($resp->getSpP())){
            $data['sp_p'] = $resp->getSpP();
        }
        if(!is_null($resp->getLP())){
            $data['l_p'] = $resp->getLP();
        }
        if(!is_null($resp->getLPer())){
            $data['l_per'] = $resp->getLPer();
            if(is_array($data['l_per'])){
                $data['l_per'] = json_encode($data['l_per']);
            }
        }
        if(!is_null($resp->getUvcPer())){
            $data['uvc_per'] = $resp->getUvcPer();
            if(is_array($data['uvc_per'])){
                $data['uvc_per'] = json_encode($data['uvc_per']);
            }
        }
        if(!is_null($resp->getSpPer())){
            $data['sp_per'] = $resp->getSpPer();
            if(is_array($data['sp_per'])){
                $data['sp_per'] = json_encode($data['sp_per']);
            }
        }
        if(!is_null($resp->getExDev())){
            $data['ex_dev'] = $resp->getExDev();
        }

        if(!is_null($resp->getDevLock())){
            $data['dev_lock'] = $resp->getDevLock();
        }

        if(!is_null($resp->getUpdState()) && $resp->getUpdState() > -1){
            $data['upd_state']  = $resp->getUpdState();
        }else{
            $data['upd_state'] = 0;
        }

        if(!is_null($resp->getDevLock())){
            $data['dev_lock'] = $resp->getDevLock();
        }
        if(!is_null($resp->getPushCfg())){
            $data['push_cfg']  = $resp->getPushCfg();
        }

        if(!is_null($resp->getDCyc())){
            $data['d_cyc']  = $resp->getDCyc();
        }

        if(!is_null($resp->getUvWh())){
            $data['uv_wh']  = $resp->getUvWh();
        }

        if(!is_null($resp->getPWh())){
            $data['p_wh']  = $resp->getPWh();
        }

        if(!is_null($resp->getLWh())){
            $data['l_wh']  = $resp->getLWh();
        }
        return $data;
    }
}