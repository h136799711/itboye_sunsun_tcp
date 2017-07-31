<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\filter_vat\action;


use sunsun\decoder\SunsunTDS;
use sunsun\filter_vat\dal\FilterVatDeviceDal;
use sunsun\filter_vat\req\FilterVatLoginReq;
use sunsun\filter_vat\resp\FilterVatLoginResp;
use sunsun\helper\LogHelper;

class FilterVatLoginAction
{
    public function login($did, $clientId, FilterVatLoginReq $req)
    {
        $resp = new  FilterVatLoginResp();
        $resp->setSn($req->getSn());
        $resp->setHb(30);
        $dal = new FilterVatDeviceDal();
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

        $dal = new FilterVatDeviceDal();
        LogHelper::logDebug($clientId, 'updateEntity' . json_encode($entity));

        $ret = $dal->updateByDid($did, $entity);

        $resp->setLoginSuccess();

        return $resp;
    }

}