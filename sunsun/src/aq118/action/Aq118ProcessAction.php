<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\aq118\action;


use sunsun\aq118\req\Aq118ReqFactory;
use sunsun\aq118\req\Aq118ReqType;
use sunsun\aq118\resp\Aq118HbResp;
use sunsun\aq118\resp\Aq118RespFactory;
use sunsun\aq118\resp\Aq118RespType;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;
use sunsun\server\factory\DeviceFacadeFactory;

/**
 * Class Aq118ProcessAction
 * 统一处理请求或响应
 * @package sunsun\aq118\action
 */
class Aq118ProcessAction
{

    /**
     * aq118除了设备登录之外的其它请求处理
     * @param $did
     * @param string $clientId tcp通道标识
     * @param array $jsonDecode 明文传输过来的数据json格式
     * @return BaseRespPo   exception
     * @internal array
     */
    public function process($did, $clientId, $jsonDecode)
    {
        if (is_array($jsonDecode)) {
            if (array_key_exists("reqType", $jsonDecode)) {
                //1. 设备主动请求的数据
                return $this->request($did, $clientId, $jsonDecode);
            } elseif (array_key_exists("resType", $jsonDecode)) {
                //2. 设备被动响应的数据
                return $this->response($did, $clientId, $jsonDecode);
            }
        }
        return null;
    }

    /**
     * 设备向服务器请求之后，服务器的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\adt\resp\AdtHbResp|\sunsun\aph300\resp\Aph300CtrlDeviceResp|\sunsun\aph300\resp\Aph300DeviceInfoResp|\sunsun\aph300\resp\Aph300DeviceUpdateResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\aq806\resp\Aq806HbResp|\sunsun\cp1000\resp\Cp1000CtrlDeviceResp|\sunsun\cp1000\resp\Cp1000DeviceFirmwareUpdateResp|\sunsun\cp1000\resp\Cp1000DeviceInfoResp|\sunsun\cp1000\resp\Cp1000HbResp|\sunsun\filter_vat\resp\FilterVatCtrlDeviceResp|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|\sunsun\filter_vat\resp\FilterVatDeviceInfoResp|\sunsun\filter_vat\resp\FilterVatDeviceUpdateResp|\sunsun\filter_vat\resp\FilterVatHbResp|\sunsun\filter_vat\resp\FilterVatLoginResp|\sunsun\heating_rod\resp\HeatingRodCtrlDeviceResp|\sunsun\heating_rod\resp\HeatingRodDeviceInfoResp|\sunsun\heating_rod\resp\HeatingRodDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpCtrlDeviceResp|\sunsun\water_pump\resp\WaterPumpDeviceInfoResp|\sunsun\water_pump\resp\WaterPumpDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpHbResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = Aq118ReqFactory::create($reqType, $jsonData);
        $resp = null;

        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {

            //已登录成功后的登录请求
            case Aq118RespType::Login:
                $resp = (new Aq118LoginAction())->deviceLogin($did, $clientId, $req);
                break;
            //心跳请求
            case Aq118ReqType::Heartbeat:
                $resp = (new Aq118HbAction())->deviceHeartBeat($did, $clientId, $req);
                break;
            case Aq118ReqType::Event:
                $resp = (new Aq118DeviceEventAction())->deviceEventLog($did, $clientId, $req);
                break;
            default:
                break;
        }
        return $resp;
    }

    /**
     * 服务器向设备请求之后，设备响应的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return Aq118HbResp
     * @throws \Exception
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $resp = Aq118RespFactory::create($resType, $jsonData);
        $retResp = null;
        if (empty($resp)) {
            return $retResp;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        switch ($resp->getRespType()) {
            //设备信息响应
            case Aq118RespType::DeviceInfo:
                $result = (new Aq118DeviceInfoAction())->deviceInfoUpdate($did, $clientId, $resp, $dal);
                break;
            //设备设置/控制响应
            case Aq118RespType::Control:
                $result = (new Aq118DeviceCtrlAction())->deviceControlInfoUpdate($did, $clientId, $resp, $dal);
                break;
            case Aq118RespType::FirmwareUpdate:
                $result = (new Aq118DeviceUpdateAction())->firmUpdate($did, $clientId, $resp);
                break;
            default:
                break;
        }

        if (!ResultHelper::isSuccess($result)) {
            LogHelper::debug($did, $clientId, $result['info']);
        }

        return $retResp;
    }
}