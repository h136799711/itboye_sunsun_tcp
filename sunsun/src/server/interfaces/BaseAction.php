<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-16
 * Time: 11:30
 */

namespace sunsun\server\interfaces;

use sunsun\decoder\SunsunTDS;
use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;
use sunsun\server\consts\SunsunDeviceConstant;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\model\BaseDeviceEventModel;
use sunsun\server\req\BaseDeviceEventClientReq;
use sunsun\server\req\BaseDeviceLoginClientReq;
use sunsun\server\req\BaseHeartBeatClientReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;
use sunsun\server\resp\BaseDeviceInfoClientResp;
use sunsun\transfer_station\client\TransferClient;

/**
 * 通用设备处理类
 * Class BaseAction
 * @package sunsun\server\interfaces
 */
abstract class BaseAction
{
    /**
     * 通用设备信息更新
     * @param string $did
     * @param string $clientId
     * @param BaseRespPo $resp
     * @param BaseDalV2 $dal
     * @return array
     * @throws \Exception
     */
    public function deviceInfoUpdate($did, $clientId, BaseRespPo $resp, BaseDalV2 $dal)
    {
        if (!method_exists($resp, 'toDbEntityArray')) {
            throw new \Exception('resp toDbEntityArray method missing');
        }
        // 更新设备信息
        $updateEntity = $resp->toDbEntityArray();
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn());
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

    /**
     * 通用设备心跳请求
     * @param $did
     * @param $clientId
     * @param BaseHeartBeatClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\aph300\resp\Aph300CtrlDeviceResp|\sunsun\aph300\resp\Aph300DeviceInfoResp|\sunsun\aph300\resp\Aph300DeviceUpdateResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\cp1000\resp\Cp1000CtrlDeviceResp|\sunsun\cp1000\resp\Cp1000DeviceFirmwareUpdateResp|\sunsun\cp1000\resp\Cp1000DeviceInfoResp|\sunsun\cp1000\resp\Cp1000HbResp|\sunsun\heating_rod\resp\HeatingRodCtrlDeviceResp|\sunsun\heating_rod\resp\HeatingRodDeviceInfoResp|\sunsun\heating_rod\resp\HeatingRodDeviceUpdateResp
     */
    public function deviceHeartBeat($did, $clientId, BaseHeartBeatClientReq $req)
    {
        (DeviceFacadeFactory::getDeviceDal($did))->updateByDid($did, ['update_time' => time()]);
        $respObj = RespFacadeFactory::createHeartBeatRespObj($did, $req);
        return $respObj;
    }

    /**
     * 设备控制设备信息返回更新
     * @param $did
     * @param $clientId
     * @param BaseRespPo|BaseDeviceInfoClientResp $resp
     * @param BaseDalV2 $dal
     * @return array
     * @throws \Exception
     */
    public function deviceControlInfoUpdate($did, $clientId, BaseDeviceInfoClientResp $resp, BaseDalV2 $dal)
    {
        if (!method_exists($resp, 'toDbEntityArray')) {
            throw new \Exception('resp toDbEntityArray method missing');
        }
        //更新设备信息
        $updateEntity = $resp->toDbEntityArray();
        $avg = DevToServerDelayHelper::logRespTime($clientId, $resp);
        if ($avg > 12345679.999) {
            $avg = 12345679.999;
        }
        if ($avg > 0) {
            $updateEntity['delay_avg'] = $avg;
        }
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn());
        $updateEntity['update_time'] = time();
        if (method_exists($dal, 'updateByDid')) {
            $ret = $dal->updateByDid($did, $updateEntity);
            return ResultHelper::success($ret);
        } else {
            return ResultHelper::fail('updateByDid method missing');
        }
    }

    /**
     * 通用设备固件更新
     * @param $did
     * @param $clientId
     * @param BaseDeviceFirmwareUpdateClientResp $resp
     * @return array
     */
    public function firmUpdate($did, $clientId, BaseDeviceFirmwareUpdateClientResp $resp)
    {
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        //更新设备信息
        $updateEntity = [
            'device_state' => $resp->getState(),
            'update_time' => time()
        ];
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

    /**
     * 通用设备登录
     * @param $did
     * @param $clientId
     * @param BaseDeviceLoginClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\adt\resp\AdtHbResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\aq806\resp\Aq806HbResp|\sunsun\filter_vat\resp\FilterVatCtrlDeviceResp|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|\sunsun\filter_vat\resp\FilterVatDeviceInfoResp|\sunsun\filter_vat\resp\FilterVatDeviceUpdateResp|\sunsun\filter_vat\resp\FilterVatHbResp|\sunsun\filter_vat\resp\FilterVatLoginResp|\sunsun\water_pump\resp\WaterPumpCtrlDeviceResp|\sunsun\water_pump\resp\WaterPumpDeviceInfoResp|\sunsun\water_pump\resp\WaterPumpDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpHbResp
     */
    public function deviceLogin($did, $clientId, BaseDeviceLoginClientReq $req)
    {
        $resp = RespFacadeFactory::createLoginRespObj($did, $req);
        $dal = DeviceFacadeFactory::getDeviceDal($did);

        $resp->setSn($req->getSn());
        $resp->setHb(SunsunDeviceConstant::DEFAULT_HEART_BEAT);
        $result = $dal->getInfoByDid($did);
        if (empty($result)) {
            $resp->setLoginFail();
            return $resp;
        }
        $pwd = $result['pwd'];
        $hb = $result['hb'];
        $resp->setHb($hb);
        //更新设备信息
        $encryptPwd = $req->getPwd();

        $originPwd = SunsunTDS::isLegalPwd($encryptPwd, $pwd);
        if (empty($originPwd)) {
            $resp->setLoginFail();
            return $resp;
        }

        //更新控制密码
        $time = time();
        $ver = $req->getVer();
        $entity = [
            'ver' => $ver,
            'offline_notify' => 1,
            'ctrl_pwd' => $originPwd,
            'last_login_time' => $time,
            'update_time' => $time,
        ];

        $ret = $dal->updateByDid($did, $entity);

        $resp->setLoginSuccess();

        return $resp;

    }

    /**
     * 通用设备推送事件记录
     * @param $did
     * @param $client_id
     * @param BaseDeviceEventClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\adt\resp\AdtHbResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\aq806\resp\Aq806HbResp|\sunsun\filter_vat\resp\FilterVatCtrlDeviceResp|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|\sunsun\filter_vat\resp\FilterVatDeviceInfoResp|\sunsun\filter_vat\resp\FilterVatDeviceUpdateResp|\sunsun\filter_vat\resp\FilterVatHbResp|\sunsun\filter_vat\resp\FilterVatLoginResp|\sunsun\water_pump\resp\WaterPumpCtrlDeviceResp|\sunsun\water_pump\resp\WaterPumpDeviceInfoResp|\sunsun\water_pump\resp\WaterPumpDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpHbResp
     */
    public function deviceEventLog($did, $client_id, BaseDeviceEventClientReq $req)
    {
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        $do = new BaseDeviceEventModel();
        $eventType = $req->getCode();
        $eventInfo = json_encode($req->getEventInfo());
        $now = time();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $dal->insert($do);

        $resp = RespFacadeFactory::createDeviceEventRespObj($did, $req);
        $resp->setState(0);
        return $resp;
    }

}