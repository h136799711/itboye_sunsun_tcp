<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\cp1000\action;


use sunsun\cp1000\req\Cp1000ReqFactory;
use sunsun\cp1000\req\Cp1000ReqType;
use sunsun\cp1000\resp\Cp1000HbResp;
use sunsun\cp1000\resp\Cp1000RespFactory;
use sunsun\cp1000\resp\Cp1000RespType;
use sunsun\cp1000\resp\Cp1000UnknownResp;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;

/**
 * Class Cp1000ProcessAction
 * 统一处理请求或响应
 * @package sunsun\cp1000\action
 */
class Cp1000ProcessAction
{

    /**
     * cp1000除了设备登录之外的其它请求处理
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
     * @return Cp1000HbResp
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $sn = $jsonData['sn'];
        $resp = Cp1000RespFactory::create($resType, $jsonData);
        $retResp = null;
        if (empty($resp)) {
            return $retResp;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        switch ($resp->getRespType()) {
            //设备信息响应
            case Cp1000RespType::DeviceInfo:
                $result = (new Cp1000DeviceInfoAction())->updateInfo($did, $clientId, $resp);
                break;
            //设备设置/控制响应
            case Cp1000RespType::Control:
                $result = (new Cp1000DeviceCtrlAction())->updateInfo($did, $clientId, $resp);
                break;
            case Cp1000RespType::FirmwareUpdate:
                $result = (new Cp1000DeviceUpdateAction())->updateInfo($did, $clientId, $resp);
                break;
            default:
                break;
        }

        if (!ResultHelper::isSuccess($result)) {
        } else {
            //TODO: 响应请求成功后，暂时返回一个心跳包或者不返回
//            $retResp = new Cp1000HbResp();
//            $retResp->setSn($sn);
        }

        return $retResp;
    }

    /**
     * 设备向服务器请求之后，服务器的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return null|\sunsun\cp1000\resp\Cp1000DeviceEventResp|Cp1000HbResp|Cp1000UnknownResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = Cp1000ReqFactory::create($reqType, $jsonData);
        $resp = null;

        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {

            //已登录成功后的登录请求
            case Cp1000RespType::Login:
                $resp = (new Cp1000LoginAction())->login($did, $clientId, $req);
                break;
            //心跳请求
            case Cp1000ReqType::Heartbeat:
                $resp = (new Cp1000HbAction())->heartBeat($clientId, $req);
                break;
            case Cp1000ReqType::Event:
                $resp = (new Cp1000DeviceEventAction())->logEvent($did, $clientId, $req);
                break;
            default:
                break;
        }
        return $resp;
    }
}