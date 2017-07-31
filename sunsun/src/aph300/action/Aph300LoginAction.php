<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aph300\action;


use sunsun\aph300\dal\Aph300DeviceDal;
use sunsun\aph300\req\Aph300LoginReq;
use sunsun\aph300\resp\Aph300LoginResp;
use sunsun\decoder\SunsunTDS;
use sunsun\helper\LogHelper;

class Aph300LoginAction
{
    public function login($did, $clientId, Aph300LoginReq $req)
    {
        $resp = new  Aph300LoginResp();
        $resp->setSn($req->getSn());
        $resp->setHb(30);
        $dal = new Aph300DeviceDal();
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
        $ver = $result['ver'];
        $entity = [
            'ver'=>$ver,
            'offline_notify'=>1,
            'ctrl_pwd' => $originPwd,
            'last_login_time' => $time,
            'update_time' => $time,
        ];

        $dal = new Aph300DeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($entity));

        $ret = $dal->updateByDid($did, $entity);

        $resp->setLoginSuccess();

        return $resp;
    }

}