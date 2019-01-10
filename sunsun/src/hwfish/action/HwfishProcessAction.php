<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\hwfish\action;


use sunsun\hwfish\req\HwfishReqFactory;
use sunsun\hwfish\req\HwfishReqType;
use sunsun\hwfish\resp\HwfishHbResp;
use sunsun\hwfish\resp\HwfishRespFactory;
use sunsun\hwfish\resp\HwfishRespType;
use sunsun\hwfish\resp\HwfishUnknownResp;
use sunsun\po\BaseRespPo;
use sunsun\server\factory\DeviceFacadeFactory;

/**
 * Class HwfishProcessAction
 * 统一处理请求或响应
 * @package sunsun\hwfish\action
 */
class HwfishProcessAction
{

    /**
     * hwfish除了设备登录之外的其它请求处理
     * @param $did
     * @param string $clientId tcp通道标识
     * @param array $jsonDecode 明文传输过来的数据json格式
     * @return BaseRespPo   exception
     * @throws \Exception
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
     * @return null|\sunsun\hwfish\resp\HwfishDeviceEventResp|HwfishHbResp|HwfishUnknownResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = HwfishReqFactory::create($reqType, $jsonData);
        $resp = null;

        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {

            //已登录成功后的登录请求
            case HwfishRespType::Login:
                $resp = (new HwfishLoginAction())->deviceLogin($did, $clientId, $req);
                break;
            //心跳请求
            case HwfishReqType::Heartbeat:
                $resp = (new HwfishHbAction())->deviceHeartBeat($did, $clientId, $req);
                break;
            case HwfishReqType::Event:
                $resp = (new HwfishDeviceEventAction())->deviceEventLog($did, $clientId, $req);
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
     * @return HwfishHbResp
     * @throws \Exception
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $resp = HwfishRespFactory::create($resType, $jsonData);
        if (empty($resp)) {
            return null;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        switch ($resp->getRespType()) {
            //设备信息响应
            case HwfishRespType::DeviceInfo:
                $result = (new HwfishDeviceInfoAction())->deviceInfoUpdate($did, $clientId, $resp, $dal);
                break;
            //设备设置/控制响应
            case HwfishRespType::Control:
                $result = (new HwfishDeviceCtrlAction())->deviceControlInfoUpdate($did, $clientId, $resp, $dal);
                break;
            case HwfishRespType::FirmwareUpdate:
                $result = (new HwfishDeviceUpdateAction())->firmUpdate($did, $clientId, $resp);
                break;
            default:
                break;
        }

        return $resp;
    }
}