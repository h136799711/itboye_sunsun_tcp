<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 09:47
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\aq806\dal\Aq806DeviceDal;
use sunsun\aq806\req\Aq806DeviceInfoReq;
use sunsun\decoder\SunsunTDS;
use sunsun\transfer_station\interfaces\DeviceClientInterface;


class Aq806Client extends BaseClient implements DeviceClientInterface
{
    public function deviceInfo()
    {
        // TODO: Implement deviceInfo() method.
    }

    public function firmwareUpdate()
    {
        // TODO: Implement firmwareUpdate() method.
    }

    private function setRegisterAddr(){
        Gateway::$registerAddress = "101.37.37.167:1238";
    }

    public function getInfo($client_id,$did, $pwd=''){
        if(empty($pwd)){
            $pwd = $this->getDevicePwd($did);
        }
        $req = new Aq806DeviceInfoReq();
        $req->setSn($this->getSn());
        $data = SunsunTDS::encode($req->toDataArray(), $pwd);
        $this->setRegisterAddr();
        $this->staticsDelay($req->getSn(),$client_id);
        Gateway::sendToClient($client_id,$data);
    }

    protected function getDevicePwd($did){
        $result = (new Aq806DeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }
}