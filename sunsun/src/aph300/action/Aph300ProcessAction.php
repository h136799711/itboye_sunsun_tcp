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
use sunsun\aph300\resp\Aph300UnknownResp;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;

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
        $sn = $jsonData['sn'];
        $resp = Aph300RespFactory::create($resType, $jsonData);
        $retResp = null;
        if (empty($resp)) {
            return $retResp;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        switch ($resp->getRespType()) {
            //设备信息响应
            case Aph300RespType::DeviceInfo:
                $result = (new Aph300DeviceInfoAction())->updateInfo($did, $clientId, $resp);
                break;
            //设备设置/控制响应
            case Aph300RespType::Control:
                $result = (new Aph300DeviceCtrlAction())->updateInfo($did, $clientId, $resp);
                break;
            case Aph300RespType::FirmwareUpdate:
                $result = (new Aph300DeviceUpdateAction())->updateInfo($did, $clientId, $resp);
                break;
            default:
                break;
        }

        if (!ResultHelper::isSuccess($result)) {
        } else {
            //TODO: 响应请求成功后，暂时返回一个心跳包或者不返回
//            $retResp = new Aph300HbResp();
//            $retResp->setSn($sn);
        }

        return $retResp;
    }

    /**
     * 设备向服务器请求之后，服务器的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return null|\sunsun\aph300\resp\Aph300DeviceEventResp|Aph300HbResp|Aph300UnknownResp
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
                $resp = (new Aph300LoginAction())->login($did, $clientId, $req);
                break;
            //心跳请求
            case Aph300ReqType::Heartbeat:
                $resp = (new Aph300HbAction())->heartBeat($did, $clientId, $req);
                break;
            case Aph300ReqType::Event:
                $resp = (new Aph300DeviceEventAction())->logEvent($did, $clientId, $req);
                break;
            default:
                break;
        }
        return $resp;
    }
}