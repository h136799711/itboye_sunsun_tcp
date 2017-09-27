<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 09:50
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\decoder\SunsunTDS;
use sunsun\heating_rod\dal\HeatingRodDeviceDal;
use sunsun\heating_rod\req\HeatingRodDeviceInfoReq;


class HeatingRodClient extends BaseClient
{
    private function setRegisterAddr(){
        Gateway::$registerAddress = "101.37.37.167:1239";
    }
    public function getInfo($client_id,$did, $pwd=''){
        if(empty($pwd)){
            $pwd = $this->getDevicePwd($did);
        }
        $req = new HeatingRodDeviceInfoReq();
        $req->setSn($this->getSn());
        $data = SunsunTDS::encode($req->toDataArray(), $pwd);
        $this->setRegisterAddr();
        $this->staticsDelay($req->getSn(),$client_id);
        Gateway::sendToClient($client_id,$data);
    }

    protected function getDevicePwd($did){
        $result = (new HeatingRodDeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }
}