<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\water_pump\action;


use sunsun\po\BaseRespPo;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\water_pump\req\WaterPumpReqFactory;
use sunsun\water_pump\req\WaterPumpReqType;
use sunsun\water_pump\resp\WaterPumpHbResp;
use sunsun\water_pump\resp\WaterPumpRespFactory;
use sunsun\water_pump\resp\WaterPumpRespType;
use sunsun\water_pump\resp\WaterPumpUnknownResp;

/**
 * Class WaterPumpProcessAction
 * 统一处理请求或响应
 * @package sunsun\water_pump\action
 */
class WaterPumpProcessAction
{

    /**
     * water_pump除了设备登录之外的其它请求处理
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
     * @return WaterPumpHbResp
     * @throws \Exception
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $resp = WaterPumpRespFactory::create($resType, $jsonData);
        if (empty($resp)) {
            return null;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        switch ($resp->getRespType()) {
            //设备信息响应
            case WaterPumpRespType::DeviceInfo:
                $result = (new WaterPumpDeviceInfoAction())->deviceInfoUpdate($did, $clientId, $resp, $dal);
                break;
            //设备设置/控制响应
            case WaterPumpRespType::Control:
                $result = (new WaterPumpDeviceCtrlAction())->deviceControlInfoUpdate($did, $clientId, $resp, $dal);
                break;
            case WaterPumpRespType::FirmwareUpdate:
                $result = (new WaterPumpDeviceUpdateAction())->firmUpdate($did, $clientId, $resp);
                break;
            default:
                break;
        }

        return $resp;
    }

    /**
     * 设备向服务器请求之后，服务器的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return null|\sunsun\water_pump\resp\WaterPumpDeviceEventResp|WaterPumpHbResp|WaterPumpUnknownResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = WaterPumpReqFactory::create($reqType, $jsonData);
        $resp = null;

        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {

            //已登录成功后的登录请求
            case WaterPumpRespType::Login:
                $resp = (new WaterPumpLoginAction())->deviceLogin($did, $clientId, $req);
                break;
            //心跳请求
            case WaterPumpReqType::Heartbeat:
                $resp = (new WaterPumpHbAction())->deviceHeartBeat($did, $clientId, $req);
                break;
            case WaterPumpReqType::Event:
                $resp = (new WaterPumpDeviceEventAction())->deviceEventLog($did, $clientId, $req);
                break;
            default:
                break;
        }
        return $resp;
    }
}