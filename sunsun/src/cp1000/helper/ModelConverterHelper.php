<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-20
 * Time: 11:14
 */

namespace sunsun\cp1000\helper;


use sunsun\cp1000\resp\Cp1000CtrlDeviceResp;
use sunsun\cp1000\resp\Cp1000DeviceInfoResp;

class ModelConverterHelper
{
    /**
     * 转换到数据库的
     * @param Cp1000DeviceInfoResp $resp
     * @return array
     */
    public static function convertToModelArray(Cp1000DeviceInfoResp $resp)
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

        if (!is_null($resp->getPushCfg())) {
            $data['push_cfg'] = $resp->getPushCfg();
        }

        if (!is_null($resp->getGear())) {
            $data['gear'] = $resp->getGear();
        }

        if (!is_null($resp->getMode())) {
            $data['mode'] = $resp->getMode();
        }
        if (!is_null($resp->getBLife())) {
            $data['b_life'] = $resp->getBLife();
        }
        if (!is_null($resp->getChCnt())) {
            $data['ch_cnt'] = $resp->getChCnt();
        }
        if (!is_null($resp->getState())) {
            $data['state'] = $resp->getState();
        }
        if (!is_null($resp->getWh())) {
            $data['wh'] = $resp->getWh();
        }
        if (!is_null($resp->getBatt())) {
            $data['batt'] = $resp->getBatt();
        }
        if (!is_null($resp->getRct())) {
            $data['rct'] = $resp->getRct();
        }

        return $data;
    }

    public static function convertToModelArrayOfCtrlDeviceResp(Cp1000CtrlDeviceResp $resp)
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

        if (!is_null($resp->getPushCfg())) {
            $data['push_cfg'] = $resp->getPushCfg();
        }
        if (!is_null($resp->getGear())) {
            $data['gear'] = $resp->getGear();
        }

        if (!is_null($resp->getMode())) {
            $data['mode'] = $resp->getMode();
        }
        if (!is_null($resp->getBLife())) {
            $data['b_life'] = $resp->getBLife();
        }
        if (!is_null($resp->getChCnt())) {
            $data['ch_cnt'] = $resp->getChCnt();
        }
        if (!is_null($resp->getState())) {
            $data['state'] = $resp->getState();
        }
        if (!is_null($resp->getWh())) {
            $data['wh'] = $resp->getWh();
        }
        if (!is_null($resp->getBatt())) {
            $data['batt'] = $resp->getBatt();
        }
        if (!is_null($resp->getRct())) {
            $data['rct'] = $resp->getRct();
        }

        return $data;
    }
}