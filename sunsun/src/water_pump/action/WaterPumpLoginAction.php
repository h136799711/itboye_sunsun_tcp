<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\water_pump\action;


use sunsun\decoder\SunsunTDS;
use sunsun\helper\LogHelper;
use sunsun\server\consts\SunsunDeviceConstant;
use sunsun\water_pump\dal\WaterPumpDeviceDal;
use sunsun\water_pump\req\WaterPumpLoginReq;
use sunsun\water_pump\resp\WaterPumpLoginResp;

class WaterPumpLoginAction
{
    public function login($did, $clientId, WaterPumpLoginReq $req)
    {
        $resp = new  WaterPumpLoginResp();
        $resp->setSn($req->getSn());
        $resp->setHb(SunsunDeviceConstant::DEFAULT_HEART_BEAT);
        $dal = new WaterPumpDeviceDal();
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
            'ver'=>$ver,
            'ctrl_pwd' => $originPwd,
            'last_login_time' => $time,
            'update_time' => $time,
            'offline_notify'=>1,
        ];

        $dal = new WaterPumpDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($entity));

        $ret = $dal->updateByDid($did, $entity);

        $resp->setLoginSuccess();

        return $resp;
    }

}