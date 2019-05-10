<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 11:13
 */

namespace sunsun\transfer_station\client;



use sunsun\helper\Des;
use sunsun\po\BaseReqPo;

class BaseClient
{
    protected function staticsDelay($sn, $client_id)
    {

    }

    protected function getSn(){
        $str = "".time().rand(0,1000);
        $str = substr($str,2,strlen($str));
        $sn =  intval($str);
        return intval($sn % 7483648);
    }

    protected function getEncryptPacketStr(BaseReqPo $req, $pwd) {
        return Des::encrypt(json_encode($req->toDataArray()), $pwd);
    }

}