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
use sunsun\transfer_station\client\TransferClient;

abstract class BaseAction
{

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

    public function deviceHeartBeat($did, $clientId, BaseHeartBeatClientReq $req)
    {
        (DeviceFacadeFactory::getDeviceDal($did))->updateByDid($did, ['update_time' => time()]);
        $respObj = RespFacadeFactory::createHeartBeatRespObj($did, $req);
        return $respObj;
    }

    /**
     * 更新设备信息
     * @param $did
     * @param $clientId
     * @param BaseRespPo $resp
     * @param BaseDalV2 $dal
     * @return array
     * @throws \Exception
     */
    public function deviceControlInfoUpdate($did, $clientId, BaseRespPo $resp, BaseDalV2 $dal)
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

    public function deviceLogin($did, $clientId, BaseDeviceLoginClientReq $req)
    {
        $resp = DeviceFacadeFactory::createLoginResp($did);
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

    public function deviceEventLog($did, $client_id, BaseDeviceEventClientReq $req)
    {
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        $do = new BaseDeviceEventModel();
        $eventType = $req->getCode();
        $eventInfo = json_encode([]);
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