<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-20
 * Time: 11:14
 */

namespace sunsun\adt\helper;


use sunsun\adt\resp\AdtCtrlDeviceResp;
use sunsun\adt\resp\AdtDeviceInfoResp;

class ModelConverterHelper
{
    public static function convertToModelArray(AdtDeviceInfoResp $resp)
    {
        $data = [];

        if (!is_null($resp->getMode())) {
            $data['mode'] = $resp->getMode();
        }
        if (!is_null($resp->getR())) {
            $data['r'] = $resp->getR();
        }
        if (!is_null($resp->getG())) {
            $data['g'] = $resp->getG();
        }
        if (!is_null($resp->getB())) {
            $data['b'] = $resp->getB();
        }
        if (!is_null($resp->getW())) {
            $data['w'] = $resp->getW();
        }
        if (!is_null($resp->getSw())) {
            $data['sw'] = $resp->getSw();
        }

        if (!is_null($resp->getPer())) {
            $data['per'] = $resp->getPer();
            if (is_array($data['per'])) {
                $data['per'] = json_encode($data['per']);
            }
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

        return $data;
    }

    public static function convertToModelArrayOfCtrlDeviceResp(AdtCtrlDeviceResp $resp)
    {
        $data = [];

        if (!is_null($resp->getMode())) {
            $data['mode'] = $resp->getMode();
        }
        if (!is_null($resp->getR())) {
            $data['r'] = $resp->getR();
        }
        if (!is_null($resp->getG())) {
            $data['g'] = $resp->getG();
        }
        if (!is_null($resp->getB())) {
            $data['b'] = $resp->getB();
        }
        if (!is_null($resp->getW())) {
            $data['w'] = $resp->getW();
        }
        if (!is_null($resp->getSw())) {
            $data['sw'] = $resp->getSw();
        }

        if (!is_null($resp->getPer())) {
            $data['per'] = $resp->getPer();
            if (is_array($data['per'])) {
                $data['per'] = json_encode($data['per']);
            }
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

        return $data;
    }
}