<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 09:47
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\cp1000\dal\Cp1000DeviceDal;
use sunsun\cp1000\req\Cp1000DeviceInfoReq;
use sunsun\decoder\SunsunTDS;
use sunsun\transfer_station\DeviceClientInterface;

class Cp1000Client extends BaseClient implements DeviceClientInterface
{
    public function deviceInfo()
    {
        // TODO: Implement deviceInfo() method.
    }

    public function firmwareUpdate()
    {
        // TODO: Implement firmwareUpdate() method.
    }

    private function setRegisterAddr()
    {
        Gateway::$registerAddress = "101.37.37.167:1243";
    }

    public function getInfo($client_id, $did, $pwd = '')
    {
        if (empty($pwd)) {
            $pwd = $this->getDevicePwd($did);
        }
        $req = new Cp1000DeviceInfoReq();
        $req->setSn($this->getSn());
        $data = SunsunTDS::encode($req->toDataArray(), $pwd);
        $this->setRegisterAddr();
        $this->staticsDelay($req->getSn(), $client_id);
        Gateway::sendToClient($client_id, $data);
    }

    protected function getDevicePwd($did)
    {
        $result = (new Cp1000DeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }
}