<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\aq806\action;


use sunsun\aq806\req\Aq806ReqFactory;
use sunsun\aq806\req\Aq806ReqType;
use sunsun\aq806\resp\Aq806HbResp;
use sunsun\aq806\resp\Aq806RespFactory;
use sunsun\aq806\resp\Aq806RespType;
use sunsun\aq806\resp\Aq806UnknownResp;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;

/**
 * Class Aq806ProcessAction
 * 统一处理请求或响应
 * @package sunsun\aq806\action
 */
class Aq806ProcessAction
{

    /**
     * aq806除了设备登录之外的其它请求处理
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
     * @return Aq806HbResp
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $sn = $jsonData['sn'];
        $resp = Aq806RespFactory::create($resType, $jsonData);
        $retResp = null;
        if (empty($resp)) {
            return $retResp;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        switch ($resp->getRespType()) {
            //设备信息响应
            case Aq806RespType::DeviceInfo:
                $result = (new Aq806DeviceInfoAction())->updateInfo($did, $clientId, $resp);
                break;
            //设备设置/控制响应
            case Aq806RespType::Control:
                $result = (new Aq806DeviceCtrlAction())->updateInfo($did, $clientId, $resp);
                break;
            case Aq806RespType::FirmwareUpdate:
                $result = (new Aq806DeviceUpdateAction())->updateInfo($did, $clientId, $resp);
                break;
            default:
                break;
        }

        if (!ResultHelper::isSuccess($result)) {
            \Events::log($clientId, $result['msg'], 'response_error');
        } else {
            //TODO: 响应请求成功后，暂时返回一个心跳包或者不返回
//            $retResp = new Aq806HbResp();
//            $retResp->setSn($sn);
        }

        return $retResp;
    }

    /**
     * 设备向服务器请求之后，服务器的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return null|\sunsun\aq806\resp\Aq806DeviceEventResp|Aq806HbResp|Aq806UnknownResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = Aq806ReqFactory::create($reqType, $jsonData);
        $resp = null;

        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {

            //已登录成功后的登录请求
            case Aq806RespType::Login:
                $resp = (new Aq806LoginAction())->login($did, $clientId, $req);
                break;
            //心跳请求
            case Aq806ReqType::Heartbeat:
                $resp = (new Aq806HbAction())->heartBeat($clientId, $req);
                break;
            case Aq806ReqType::Event:
                $resp = (new Aq806DeviceEventAction())->logEvent($did, $clientId, $req);
                break;
            default:
                break;
        }
        return $resp;
    }
}