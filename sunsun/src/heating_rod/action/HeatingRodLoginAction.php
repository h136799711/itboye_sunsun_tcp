<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\heating_rod\action;


use sunsun\decoder\SunsunTDS;
use sunsun\heating_rod\dal\HeatingRodDeviceDal;
use sunsun\heating_rod\req\HeatingRodLoginReq;
use sunsun\heating_rod\resp\HeatingRodLoginResp;
use sunsun\helper\LogHelper;

class HeatingRodLoginAction
{
    public function login($did, $clientId, HeatingRodLoginReq $req)
    {
        $resp = new  HeatingRodLoginResp();
        $resp->setSn($req->getSn());
        $resp->setHb(30);
        $dal = new HeatingRodDeviceDal();
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
        $entity = [
            'offline_notify'=>1,
            'ctrl_pwd' => $originPwd,
            'last_login_time' => $time,
            'update_time' => $time,
        ];

        $dal = new HeatingRodDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($entity));

        $ret = $dal->updateByDid($did, $entity);

        $resp->setLoginSuccess();

        return $resp;
    }

}