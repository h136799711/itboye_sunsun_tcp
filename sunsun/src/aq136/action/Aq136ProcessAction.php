<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\aq136\action;


use sunsun\aq136\req\Aq136ReqFactory;
use sunsun\aq136\req\Aq136ReqType;
use sunsun\aq136\resp\Aq136HbResp;
use sunsun\aq136\resp\Aq136RespFactory;
use sunsun\aq136\resp\Aq136RespType;
use sunsun\aq136\resp\Aq136UnknownResp;
use sunsun\po\BaseRespPo;
use sunsun\server\factory\DeviceFacadeFactory;

/**
 * Class Aq136ProcessAction
 * 统一处理请求或响应
 * @package sunsun\aq136\action
 */
class Aq136ProcessAction
{

    /**
     * aq136除了设备登录之外的其它请求处理
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
     * @return null|\sunsun\aq136\resp\Aq136DeviceEventResp|Aq136HbResp|Aq136UnknownResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = Aq136ReqFactory::create($reqType, $jsonData);
        $resp = null;

        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {

            //已登录成功后的登录请求
            case Aq136RespType::Login:
                $resp = (new Aq136LoginAction())->deviceLogin($did, $clientId, $req);
                break;
            //心跳请求
            case Aq136ReqType::Heartbeat:
                $resp = (new Aq136HbAction())->deviceHeartBeat($did, $clientId, $req);
                break;
            case Aq136ReqType::Event:
                $resp = (new Aq136DeviceEventAction())->deviceEventLog($did, $clientId, $req);
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
     * @return Aq136HbResp
     * @throws \Exception
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $resp = Aq136RespFactory::create($resType, $jsonData);
        if (empty($resp)) {
            return null;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        switch ($resp->getRespType()) {
            //设备信息响应
            case Aq136RespType::DeviceInfo:
                $result = (new Aq136DeviceInfoAction())->deviceInfoUpdate($did, $clientId, $resp, $dal);
                break;
            //设备设置/控制响应
            case Aq136RespType::Control:
                $result = (new Aq136DeviceCtrlAction())->deviceControlInfoUpdate($did, $clientId, $resp, $dal);
                break;
            case Aq136RespType::FirmwareUpdate:
                $result = (new Aq136DeviceUpdateAction())->firmUpdate($did, $clientId, $resp);
                break;
            default:
                break;
        }

        return $resp;
    }
}