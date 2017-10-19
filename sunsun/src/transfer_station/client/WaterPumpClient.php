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
use sunsun\transfer_station\interfaces\DeviceClientInterface;
use sunsun\water_pump\dal\WaterPumpDeviceDal;
use sunsun\water_pump\req\WaterPumpDeviceInfoReq;

class WaterPumpClient extends BaseClient implements DeviceClientInterface
{

    public function getInfo($client_id, $did, $pwd = '')
    {
        if (empty($pwd)) {
            $pwd = $this->getDevicePwd($did);
        }
        $req = new WaterPumpDeviceInfoReq();
        $req->setSn($this->getSn());
        $data = SunsunTDS::encode($req->toDataArray(), $pwd);
        $this->setRegisterAddr();
        $this->staticsDelay($req->getSn(), $client_id);
        Gateway::sendToClient($client_id, $data);
    }

    // DeviceClientInterface

    public function deviceInfo()
    {

    }

    public function firmwareUpdate()
    {
        // TODO: Implement firmwareUpdate() method.
    }

    // private function
    private function setRegisterAddr(){
        Gateway::$registerAddress = "101.37.37.167:1212";
    }

    protected function getDevicePwd($did){
        $result = (new WaterPumpDeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }
}