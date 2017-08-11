<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-10
 * Time: 15:36
 */

namespace sunsun\server\device;


use sunsun\adt\action\AdtProcessAction;
use sunsun\adt\dal\AdtDeviceDal;
use sunsun\adt\req\AdtReqFactory;
use sunsun\adt\req\AdtReqType;
use sunsun\adt\resp\AdtLoginResp;
use sunsun\aph300\action\Aph300ProcessAction;
use sunsun\aph300\dal\Aph300DeviceDal;
use sunsun\aph300\req\Aph300ReqFactory;
use sunsun\aph300\req\Aph300ReqType;
use sunsun\aph300\resp\Aph300LoginResp;
use sunsun\aq806\action\Aq806ProcessAction;
use sunsun\aq806\dal\Aq806DeviceDal;
use sunsun\aq806\req\Aq806ReqFactory;
use sunsun\aq806\req\Aq806ReqType;
use sunsun\aq806\resp\Aq806LoginResp;
use sunsun\filter_vat\action\FilterVatProcessAction;
use sunsun\filter_vat\dal\FilterVatDeviceDal;
use sunsun\filter_vat\req\FilterVatReqFactory;
use sunsun\filter_vat\req\FilterVatReqType;
use sunsun\filter_vat\resp\FilterVatLoginResp;
use sunsun\heating_rod\action\HeatingRodProcessAction;
use sunsun\heating_rod\dal\HeatingRodDeviceDal;
use sunsun\heating_rod\req\HeatingRodReqFactory;
use sunsun\heating_rod\req\HeatingRodReqType;
use sunsun\heating_rod\resp\HeatingRodLoginResp;
use sunsun\server\consts\DeviceType;
use sunsun\water_pump\action\WaterPumpProcessAction;
use sunsun\water_pump\dal\WaterPumpDeviceDal;
use sunsun\water_pump\req\WaterPumpReqFactory;
use sunsun\water_pump\req\WaterPumpReqType;
use sunsun\water_pump\resp\WaterPumpLoginResp;

class DeviceFactory
{
    /**
     * 获取公共密钥 根据端口进行处理
     *
     * @param int $port
     * @return string
     */
    public static function getPublicPwd($port=8286){
        return '1234bcda';
    }

    public static function getDb(){

    }

    /**
     * 获取设备dal
     * @param $did
     * @return null|AdtDeviceDal|Aph300DeviceDal|Aq806DeviceDal|FilterVatDeviceDal|HeatingRodDeviceDal|WaterPumpDeviceDal
     */
    public static function getDeviceDal($did){
        $type = substr($did,0,3);
        $logic = null;
        switch ($type){
            case DeviceType::Did_ADT:
                $logic = new AdtDeviceDal();
                break;
            case DeviceType::Did_APH300:
                $logic = new Aph300DeviceDal();
                break;
            case DeviceType::Did_AQ806:
                $logic = new Aq806DeviceDal();
                break;
            case DeviceType::Did_FilterVat:
                $logic = new FilterVatDeviceDal();
                break;
            case DeviceType::Did_HeatingRod:
                $logic = new HeatingRodDeviceDal();
                break;
            case DeviceType::Did_WaterPump:
                $logic = new WaterPumpDeviceDal();
                break;
            default:break;
        }
        return $logic;
    }

    /**
     * 根据did 返回相应的req
     * @param $did
     * @return null|AdtLoginResp|Aph300LoginResp|Aq806LoginResp|FilterVatLoginResp|HeatingRodLoginResp|WaterPumpLoginResp
     */
    public static function createLoginResp($did){
        $type = substr($did,0,3);
        $resp = null;
        switch ($type){
            case DeviceType::Did_ADT:
                $resp = new AdtLoginResp();
                break;
            case DeviceType::Did_APH300:
                $resp = new Aph300LoginResp();
                break;
            case DeviceType::Did_AQ806:
                $resp = new Aq806LoginResp();
                break;
            case DeviceType::Did_FilterVat:
                $resp = new FilterVatLoginResp();
                break;
            case DeviceType::Did_HeatingRod:
                $resp = new HeatingRodLoginResp();
                break;
            case DeviceType::Did_WaterPump:
                $resp = new WaterPumpLoginResp();
                break;
            default:break;
        }
        return $resp;
    }

    /**
     * @param $did
     * @param array $data
     * @return null|\sunsun\adt\req\AdtDeviceEventReq|\sunsun\adt\req\AdtDeviceInfoReq|\sunsun\adt\req\AdtHbReq|\sunsun\adt\req\AdtLoginReq|\sunsun\aph300\req\Aph300DeviceEventReq|\sunsun\aph300\req\Aph300DeviceInfoReq|\sunsun\aph300\req\Aph300HbReq|\sunsun\aph300\req\Aph300LoginReq|\sunsun\filter_vat\req\FilterVatDeviceEventReq|\sunsun\filter_vat\req\FilterVatDeviceInfoReq|\sunsun\filter_vat\req\FilterVatHbReq|\sunsun\filter_vat\req\FilterVatLoginReq|\sunsun\heating_rod\req\HeatingRodDeviceEventReq|\sunsun\heating_rod\req\HeatingRodDeviceInfoReq|\sunsun\heating_rod\req\HeatingRodHbReq|\sunsun\heating_rod\req\HeatingRodLoginReq
     */
    public static function createLoginReq($did,$data=[]){

        $type = substr($did,0,3);
        $req = null;
        switch ($type){
            case DeviceType::Did_ADT:
                $req = AdtReqFactory::create(AdtReqType::Login,$data);
                break;
            case DeviceType::Did_APH300:
                $req = Aph300ReqFactory::create(Aph300ReqType::Login,$data);
                break;
            case DeviceType::Did_AQ806:
                $req = Aq806ReqFactory::create(Aq806ReqType::Login,$data);
                break;
            case DeviceType::Did_FilterVat:
                $req = FilterVatReqFactory::create(FilterVatReqType::Login,$data);
                break;
            case DeviceType::Did_HeatingRod:
                $req = HeatingRodReqFactory::create(HeatingRodReqType::Login,$data);
                break;
            case DeviceType::Did_WaterPump:
                $req = WaterPumpReqFactory::create(WaterPumpReqType::Login, $data);
                break;
            default:break;
        }
        return $req;
    }

    /**
     * 获取处理 action
     * @param $did
     * @return null|AdtProcessAction|Aph300ProcessAction|Aq806ProcessAction|FilterVatProcessAction|HeatingRodProcessAction|WaterPumpProcessAction
     */
    public static function createProcessAction($did){
        $type = substr($did,0,3);
        $action = null;
        switch ($type){
            case DeviceType::Did_ADT:
                $action = new AdtProcessAction();
                break;
            case DeviceType::Did_APH300:
                $action = new Aph300ProcessAction();
                break;
            case DeviceType::Did_AQ806:
                $action = new Aq806ProcessAction();
                break;
            case DeviceType::Did_FilterVat:
                $action = new FilterVatProcessAction();
                break;
            case DeviceType::Did_HeatingRod:
                $action = new HeatingRodProcessAction();
                break;
            case DeviceType::Did_WaterPump:
                $action = new WaterPumpProcessAction();
                break;
            default:break;
        }
        return $action;
    }

}