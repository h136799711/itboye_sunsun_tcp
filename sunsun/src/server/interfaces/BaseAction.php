<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-16
 * Time: 11:30
 */

namespace sunsun\server\interfaces;

use sunsun\dal\BaseDal;
use sunsun\decoder\SunsunTDS;
use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;
use sunsun\server\consts\RespFacadeType;
use sunsun\server\consts\SunsunDeviceConstant;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\req\BaseDeviceLoginClientReq;
use sunsun\server\req\BaseHeartBeatClientReq;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;
use sunsun\transfer_station\client\TransferClient;

abstract class BaseAction
{


    public function deviceHeartBeat($did, $clientId, BaseHeartBeatClientReq $req)
    {
        (DeviceFacadeFactory::getDeviceDal($did))->updateByDid($did, ['update_time' => time()]);
        $respObj = RespFacadeFactory::createRespObj($did, RespFacadeType::HEART_BEAT, $req->toDataArray());
        return $respObj;
    }

    /**
     * 更新设备信息
     * @param $did
     * @param $clientId
     * @param BaseRespPo $resp
     * @param BaseDal $dal
     * @return array
     */
    public function updateDeviceInfo($did, $clientId, BaseRespPo $resp, BaseDal $dal)
    {
        if (!method_exists($resp, 'toModelArray')) {
            return ResultHelper::fail('resp toModelArray method missing');
        }
        //更新设备信息
        $updateEntity = $resp->toModelArray();
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

}