<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\pet_feeder\action;


use sunsun\pet_feeder\req\PetFeederReqFactory;
use sunsun\pet_feeder\req\PetFeederReqType;
use sunsun\pet_feeder\resp\PetFeederRespFactory;
use sunsun\pet_feeder\resp\PetFeederRespType;
use sunsun\po\BaseRespPo;
use sunsun\server\factory\DeviceFacadeFactory;

/**
 * Class PetFeederProcessAction
 * 统一处理请求或响应
 * @package sunsun\pet_feeder\action
 */
class PetFeederProcessAction
{

    /**
     * pet_feeder除了设备登录之外的其它请求处理
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
     * @return null|\sunsun\pet_feeder\resp\PetFeederHbResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = PetFeederReqFactory::create($reqType, $jsonData);
        $resp = null;
        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {

            //已登录成功后的登录请求
            case PetFeederRespType::Login:
                $resp = (new PetFeederLoginAction())->deviceLogin($did, $clientId, $req);
                break;
            //心跳请求
            case PetFeederReqType::Heartbeat:
                $resp = (new PetFeederHbAction())->deviceHeartBeat($did, $clientId, $req);
                break;
            case PetFeederReqType::Event:
                $resp = (new PetFeederDeviceEventAction())->deviceEventLog($did, $clientId, $req);
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
     * @return null|\sunsun\pet_feeder\resp\PetFeederHbResp
     * @throws \Exception
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $resp =PetFeederRespFactory::create($resType, $jsonData);
        if (empty($resp)) {
            return null;
        }

        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        switch ($resp->getRespType()) {
            //设备信息响应
            case PetFeederRespType::DeviceInfo:
                $result = (new PetFeederDeviceInfoAction())->deviceInfoUpdate($did, $clientId, $resp, $dal);
                break;
            //设备设置/控制响应
            case PetFeederRespType::Control:
                $result = (new PetFeederDeviceCtrlAction())->deviceControlInfoUpdate($did, $clientId, $resp, $dal);
                break;
            case PetFeederRespType::FirmwareUpdate:
                $result = (new PetFeederDeviceFirmwareUpdateAction())->firmUpdate($did, $clientId, $resp);
                break;
            default:
                break;
        }


        return $resp;
    }
}