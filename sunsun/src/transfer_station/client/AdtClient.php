<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 09:47
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\adt\dal\AdtDeviceDal;
use sunsun\adt\req\AdtDeviceInfoReq;
use sunsun\decoder\SunsunTDS;

Gateway::$registerAddress = "101.37.37.167:1242";

class AdtClient extends BaseClient
{
    private function setRegisterAddr(){
        Gateway::$registerAddress = "101.37.37.167:1240";
    }
    public function getInfo($client_id, $did, $pwd=''){
        if(empty($pwd)){
            $pwd = $this->getDevicePwd($did);
        }
        $req = new AdtDeviceInfoReq();
        $req->setSn($this->getSn());
        $data = SunsunTDS::encode($req->toDataArray(), $pwd);
        $this->setRegisterAddr();
        Gateway::sendToClient($client_id,$data);
    }

    protected function getDevicePwd($did){
        $result = (new AdtDeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }
}