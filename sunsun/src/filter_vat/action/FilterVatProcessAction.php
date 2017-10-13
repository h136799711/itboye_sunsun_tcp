<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 13:25
 */

namespace sunsun\filter_vat\action;


use sunsun\filter_vat\req\FilterVatReqFactory;
use sunsun\filter_vat\req\FilterVatReqType;
use sunsun\filter_vat\resp\FilterVatHbResp;
use sunsun\filter_vat\resp\FilterVatRespFactory;
use sunsun\filter_vat\resp\FilterVatRespType;
use sunsun\filter_vat\resp\FilterVatUnknownResp;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;

/**
 * Class FilterVatProcessAction
 * 统一处理请求或响应
 * @package sunsun\filter_vat\action
 */
class FilterVatProcessAction
{

    /**
     * 过滤桶除了设备登录之外的其它请求处理
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
     * @return FilterVatHbResp
     */
    private function response($did, $clientId, $jsonData)
    {
        $resType = $jsonData['resType'];
        $resp = FilterVatRespFactory::create($resType, $jsonData);
        $retResp = null;
        if (empty($resp)) {
            return $retResp;
        }
        //过滤桶除了设备登录之外的其它请求处理
        $result = false;
        switch ($resp->getRespType()) {
            //设备信息响应
            case FilterVatRespType::DeviceInfo:
                $result = (new FilterVatDeviceInfoAction())->updateInfo($did, $clientId, $resp);
                break;
            //设备设置/控制响应
            case FilterVatRespType::Control:
                $result = (new FilterVatDeviceCtrlAction())->updateInfo($did, $clientId, $resp);
                break;
            case FilterVatRespType::FirmwareUpdate:
                $result = (new FilterVatDeviceUpdateAction())->updateInfo($did, $clientId, $resp);
                break;
            default:
                break;
        }

        if (!ResultHelper::isSuccess($result)) {
        } else {
            //TODO: 响应请求成功后，暂时返回一个心跳包或者不返回
//            $retResp = new FilterVatHbResp();
//            $retResp->setSn($sn);
        }

        return $retResp;
    }

    /**
     * 设备向服务器请求之后，服务器的数据处理
     * @param $did
     * @param $clientId
     * @param $jsonData
     * @return null|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|FilterVatHbResp|FilterVatUnknownResp
     */
    private function request($did, $clientId, $jsonData)
    {

        $reqType = $jsonData['reqType'];
        //获取请求并设置请求内容
        $req = FilterVatReqFactory::create($reqType, $jsonData);
        $resp = null;

        //过滤桶除了设备登录之外的其它请求处理
        switch ($req->getReqType()) {
            //已登录成功后的登录请求
            case FilterVatRespType::Login:
                $resp = (new FilterVatLoginAction())->login($did, $clientId, $req);
                break;
            //心跳请求
            case FilterVatReqType::Heartbeat:
                $resp = (new FilterVatHbAction())->heartBeat($clientId, $req);
                break;
            case FilterVatReqType::Event:
                $resp = (new FilterVatDeviceEventAction())->logEvent($did, $clientId, $req);
                break;
            default:
                break;
        }
        return $resp;
    }
}