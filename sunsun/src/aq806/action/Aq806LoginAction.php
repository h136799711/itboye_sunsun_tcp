<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aq806\action;


use sunsun\aq806\dal\Aq806DeviceDal;
use sunsun\aq806\req\Aq806LoginReq;
use sunsun\aq806\resp\Aq806LoginResp;
use sunsun\decoder\SunsunTDS;
use sunsun\helper\LogHelper;

class Aq806LoginAction
{
    public function login($did, $clientId, Aq806LoginReq $req)
    {
        $resp = new  Aq806LoginResp();
        $resp->setSn($req->getSn());
        $resp->setHb(30);
        $dal = new Aq806DeviceDal();
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

        $dal = new Aq806DeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($entity));

        $ret = $dal->updateByDid($did, $entity);

        $resp->setLoginSuccess();

        return $resp;
    }

}