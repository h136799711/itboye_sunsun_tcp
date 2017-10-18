<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\aph300\action;


use sunsun\aph300\req\Aph300ReqFactory;
use sunsun\aph300\req\Aph300ReqType;
use sunsun\aph300\resp\Aph300HbResp;
use sunsun\aph300\resp\Aph300RespFactory;
use sunsun\aph300\resp\Aph300RespType;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;
use sunsun\server\factory\DeviceFacadeFactory;

/**
 * Class Aph300ProcessAction
 * 统一处理请求或响应
 * @package sunsun\aph300\action
 */
class Aph300ProcessAction
{

    /**
     * aph300除了设备登录之外的其它请求处理
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
     * 服务器向设备请求之后，设备响应的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return Aph300HbResp
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $resp = Aph300RespFactory::create($resType, $jsonData);
        $retResp = null;
        if (empty($resp)) {
            return $retResp;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        switch ($resp->getRespType()) {
            //设备信息响应
            case Aph300RespType::DeviceInfo:
                $result = (new Aph300DeviceInfoAction())->deviceInfoUpdate($did, $clientId, $resp, $dal);
                break;
            //设备设置/控制响应
            case Aph300RespType::Control:
                $result = (new Aph300DeviceCtrlAction())->deviceControlInfoUpdate($did, $clientId, $resp, $dal);
                break;
            case Aph300RespType::FirmwareUpdate:
                $result = (new Aph300DeviceUpdateAction())->firmUpdate($did, $clientId, $resp);
                break;
            default:
                break;
        }

        if (!ResultHelper::isSuccess($result)) {
            LogHelper::debug($did, $clientId, $result['info']);
        }

        return $retResp;
    }

    /**
     * 设备向服务器请求之后，服务器的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\aph300\resp\Aph300CtrlDeviceResp|\sunsun\aph300\resp\Aph300DeviceInfoResp|\sunsun\aph300\resp\Aph300DeviceUpdateResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\cp1000\resp\Cp1000CtrlDeviceResp|\sunsun\cp1000\resp\Cp1000DeviceFirmwareUpdateResp|\sunsun\cp1000\resp\Cp1000DeviceInfoResp|\sunsun\cp1000\resp\Cp1000HbResp|\sunsun\heating_rod\resp\HeatingRodCtrlDeviceResp|\sunsun\heating_rod\resp\HeatingRodDeviceInfoResp|\sunsun\heating_rod\resp\HeatingRodDeviceUpdateResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = Aph300ReqFactory::create($reqType, $jsonData);
        $resp = null;

        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {

            //已登录成功后的登录请求
            case Aph300RespType::Login:
                $resp = (new Aph300LoginAction())->deviceLogin($did, $clientId, $req);
                break;
            //心跳请求
            case Aph300ReqType::Heartbeat:
                $resp = (new Aph300HbAction())->deviceHeartBeat($did, $clientId, $req);
                break;
            case Aph300ReqType::Event:
                $resp = (new Aph300DeviceEventAction())->deviceEventLog($did, $clientId, $req);
                break;
            default:
                break;
        }
        return $resp;
    }
}