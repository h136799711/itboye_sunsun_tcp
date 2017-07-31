<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\adt\action;


use sunsun\adt\dal\AdtDeviceDal;
use sunsun\adt\req\AdtLoginReq;
use sunsun\adt\resp\AdtLoginResp;
use sunsun\decoder\SunsunTDS;
use sunsun\helper\LogHelper;

class AdtLoginAction
{
    public function login($did, $clientId, AdtLoginReq $req)
    {
        $resp = new  AdtLoginResp();
        $resp->setSn($req->getSn());
        $resp->setHb(30);
        $dal = new AdtDeviceDal();
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
            'offline_notify'=>1,
            'ctrl_pwd' => $originPwd,
            'last_login_time' => $time,
            'update_time' => $time,
        ];

        $dal = new AdtDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($entity));

        $ret = $dal->updateByDid($did, $entity);

        $resp->setLoginSuccess();

        return $resp;
    }

}