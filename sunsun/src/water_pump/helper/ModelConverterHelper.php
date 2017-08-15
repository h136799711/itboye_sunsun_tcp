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

        if (!is_null($resp->getDevLock())) {
            $data['dev_lock'] = $resp->getDevLock();
        }
        if (!is_null($resp->getUpdState()) && $resp->getUpdState() > -1) {
            $data['upd_state'] = $resp->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }


        if (!is_null($resp->getPwr())) {
            $data['pwr'] = $resp->getPwr();
        }
        if (!is_null($resp->getSpd())) {
            $data['spd'] = $resp->getSpd();
        }
        if (!is_null($resp->getGear())) {
            $data['gear'] = $resp->getGear();
        }
        if (!is_null($resp->getICyc())) {
            $data['i_cyc'] = $resp->getICyc();
        }
        if (!is_null($resp->getCfg())) {
            $data['cfg'] = $resp->getCfg();
        }
        if (!is_null($resp->getType())) {
            $data['device_type'] = $resp->getType();
        }
        if (!is_null($resp->getState())) {
            $data['state'] = $resp->getState();
        }
        if (!is_null($resp->getFault())) {
            $data['fault'] = $resp->getFault();
        }

        return $data;
    }

    public static function convertToModelArrayOfCtrlDeviceResp(WaterPumpCtrlDeviceResp $resp)
    {
        $data = [];

        if (!is_null($resp->getDevLock())) {
            $data['dev_lock'] = $resp->getDevLock();
        }
        if (!is_null($resp->getUpdState()) && $resp->getUpdState() > -1) {
            $data['upd_state'] = $resp->getUpdState();
        } else {
            $data['upd_state'] = 0;
        }

        if (!is_null($resp->getPwr())) {
            $data['pwr'] = $resp->getPwr();
        }
        if (!is_null($resp->getSpd())) {
            $data['spd'] = $resp->getSpd();
        }
        if (!is_null($resp->getGear())) {
            $data['gear'] = $resp->getGear();
        }
        if (!is_null($resp->getICyc())) {
            $data['i_cyc'] = $resp->getICyc();
        }
        if (!is_null($resp->getCfg())) {
            $data['cfg'] = $resp->getCfg();
        }
        if (!is_null($resp->getType())) {
            $data['type'] = $resp->getType();
        }
        if (!is_null($resp->getState())) {
            $data['state'] = $resp->getState();
        }
        if (!is_null($resp->getFault())) {
            $data['fault'] = $resp->getFault();
        }

        return $data;
    }
}