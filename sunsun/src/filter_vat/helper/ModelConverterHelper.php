<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-20
 * Time: 11:14
 */

namespace sunsun\filter_vat\helper;


use sunsun\filter_vat\resp\FilterVatCtrlDeviceResp;
use sunsun\filter_vat\resp\FilterVatDeviceInfoResp;

class ModelConverterHelper
{
    public static function convertToModelArray(FilterVatDeviceInfoResp $resp){
        $data = [];
        if(!is_null($resp->getT())){
            $data['t'] = $resp->getT();
        }
        if(!is_null($resp->getClEn())){
            $data['cl_en'] = $resp->getClEn();
        }
        if(!is_null($resp->getClWeek())) {
            $data['cl_week'] = $resp->getClWeek();
        }
        if(!is_null($resp->getClTm())){
            $data['cl_tm']  = $resp->getClTm();
        }
        if(!is_null($resp->getClDur())) {
            $data['cl_dur'] = $resp->getClDur();
        }
        if(!is_null($resp->getClState())) {
            $data['cl_state'] = $resp->getClState();
        }
        if(!is_null($resp->getClSche())) {
            $data['cl_sche'] = $resp->getClSche();
        }
        if(!is_null($resp->getClCfg())) {
            $data['cl_cfg'] = $resp->getClCfg();
        }
        if(!is_null($resp->getUvOn())) {
            $data['uv_on'] = $resp->getUvOn();
        }
        if(!is_null($resp->getUvOff())) {
            $data['uv_off'] = $resp->getUvOff();
        }
        if(!is_null($resp->getUvWH())) {
            $data['uv_wh'] = $resp->getUvWH();
        }
        if(!is_null($resp->getUvCfg())) {
            $data['uv_cfg'] = $resp->getUvCfg();
        }
        if(!is_null($resp->getOutStateA())){
            $data['out_state_a']  = $resp->getOutStateA();
        }
        if(!is_null($resp->getOutStateB())){
            $data['out_state_b']  = $resp->getOutStateB();
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

    public static function convertToModelArrayOfCtrlDeviceResp(FilterVatCtrlDeviceResp $resp){
        $data = [];
        if(!is_null($resp->getClEn())){
            $data['cl_en'] = $resp->getClEn();
        }
        if(!is_null($resp->getClWeek())) {
            $data['cl_week'] = $resp->getClWeek();
        }
        if(!is_null($resp->getClTm())){
            $data['cl_tm']  = $resp->getClTm();
        }
        if(!is_null($resp->getClDur())) {
            $data['cl_dur'] = $resp->getClDur();
        }
        if(!is_null($resp->getClState())) {
            $data['cl_state'] = $resp->getClState();
        }
        if(!is_null($resp->getClSche())) {
            $data['cl_sche'] = $resp->getClSche();
        }
        if(!is_null($resp->getClCfg())) {
            $data['cl_cfg'] = $resp->getClCfg();
        }
        if(!is_null($resp->getUvOn())) {
            $data['uv_on'] = $resp->getUvOn();
        }
        if(!is_null($resp->getUvOff())) {
            $data['uv_off'] = $resp->getUvOff();
        }
        if(!is_null($resp->getUvWH())) {
            $data['uv_wh'] = $resp->getUvWH();
        }
        if(!is_null($resp->getUvCfg())) {
            $data['uv_cfg'] = $resp->getUvCfg();
        }
        if(!is_null($resp->getOutStateA())){
            $data['out_state_a']  = $resp->getOutStateA();
        }
        if(!is_null($resp->getOutStateB())){
            $data['out_state_b']  = $resp->getOutStateB();
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