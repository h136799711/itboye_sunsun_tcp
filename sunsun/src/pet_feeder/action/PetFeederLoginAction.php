<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\pet_feeder\action;

use sunsun\dal\DeviceTcpClientDal;
use sunsun\decoder\SunsunTDS;
use sunsun\server\consts\SunsunDeviceConstant;
use sunsun\server\db\DbPool;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\interfaces\BaseActionV2;
use sunsun\server\req\BaseDeviceLoginClientReq;

class PetFeederLoginAction extends BaseActionV2
{

    public function deviceLogin($did, $clientId, BaseDeviceLoginClientReq $req)
    {
        echo $did, " 设备登录请求非首次".json_encode($req->toDataArray()), "\n";

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
        $resp->setServerInfo($result);
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

        $dal = new DeviceTcpClientDal(DbPool::getInstance()->getGlobalDb());
        $dal->updateByDid($did, ['prev_login_time' => $time]);

        $resp->setLoginSuccess();

        return $resp;

    }

}