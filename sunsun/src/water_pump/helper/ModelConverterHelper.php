<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-20
 * Time: 11:14
 */

namespace sunsun\water_pump\helper;


use sunsun\water_pump\resp\WaterPumpCtrlDeviceResp;
use sunsun\water_pump\resp\WaterPumpDeviceInfoResp;

class ModelConverterHelper
{
    /**
     * 转换到数据库的
     * @param WaterPumpDeviceInfoResp $resp
     * @return array
     */
    public static function convertToModelArray(WaterPumpDeviceInfoResp $resp)
    {
        $data = [];
        if (!is_null($resp->getT())) {
            $data['t'] = $resp->getT();
        }
        if (!is_null($resp->getPh())) {
            $data['ph'] = $resp->getPh();
        }

        if (!is_null($resp->getDevLock())) {
            $data['dev_lock'] = $resp->getDevLock();
        }
        if (!is_null($resp->getUpdState()) && $resp->getUpdState() > -1) {
            $data['upd_state'] = $resp->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }

        if (!is_null($resp->getPushCfg())) {
            $data['push_cfg'] = $resp->getPushCfg();
        }

        if (!is_null($resp->getDCyc())) {
            $data['d_cyc'] = $resp->getDCyc();
        }

        if (!is_null($resp->getPhCmd())) {
            $data['ph_cmd'] = $resp->getPhCmd();
        }
        if (!is_null($resp->getPhSche())) {
            $data['ph_sche'] = $resp->getPhSche();
        }
        if (!is_null($resp->getPhDly())) {
            $data['ph_dly'] = $resp->getPhDly();
        }
        if (!is_null($resp->getPhh())) {
            $data['phh'] = $resp->getPhh();
        }
        if (!is_null($resp->getPhl())) {
            $data['phl'] = $resp->getPhl();
        }

        if (!is_null($resp->getTh())) {
            $data['th'] = $resp->getTh();
        }if (!is_null($resp->getTl())) {
            $data['tl'] = $resp->getTl();
        }

        return $data;
    }

    public static function convertToModelArrayOfCtrlDeviceResp(WaterPumpCtrlDeviceResp $resp)
    {
        $data = [];
        if (!is_null($resp->getT())) {
            $data['t'] = $resp->getT();
        }
        if (!is_null($resp->getPh())) {
            $data['ph'] = $resp->getPh();
        }

        if (!is_null($resp->getDevLock())) {
            $data['dev_lock'] = $resp->getDevLock();
        }
        if (!is_null($resp->getUpdState()) && $resp->getUpdState() > -1) {
            $data['upd_state'] = $resp->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }

        if (!is_null($resp->getPushCfg())) {
            $data['push_cfg'] = $resp->getPushCfg();
        }

        if (!is_null($resp->getDCyc())) {
            $data['d_cyc'] = $resp->getDCyc();
        }

        if (!is_null($resp->getPhCmd())) {
            $data['ph_cmd'] = $resp->getPhCmd();
        }
        if (!is_null($resp->getPhSche())) {
            $data['ph_sche'] = $resp->getPhSche();
        }
        if (!is_null($resp->getPhDly())) {
            $data['ph_dly'] = $resp->getPhDly();
        }
        if (!is_null($resp->getPhh())) {
            $data['phh'] = $resp->getPhh();
        }
        if (!is_null($resp->getPhl())) {
            $data['phl'] = $resp->getPhl();
        }

        if (!is_null($resp->getTh())) {
            $data['th'] = $resp->getTh();
        }if (!is_null($resp->getTl())) {
            $data['tl'] = $resp->getTl();
        }

        return $data;
    }
}