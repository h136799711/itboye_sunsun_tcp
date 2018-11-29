<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 09:47
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\helper\Des;
use sunsun\pet_feeder\dal\PetFeederDeviceDal;
use sunsun\pet_feeder\req\PetFeederDeviceInfoReq;
use sunsun\server\consts\SessionKeys;
use sunsun\ServerAddress;
use sunsun\transfer_station\interfaces\DeviceClientInterface;


class PetFeederClient extends BaseClient implements DeviceClientInterface
{
    public function updateAppCnt($did, $cnt = 0)
    {
        $this->setRegisterAddr();
        $clientIds = Gateway::getClientIdByUid($did);
        if (is_array($clientIds) && count($clientIds) > 0 ) {
            $clientId = $clientIds[0];
            $session = Gateway::getSession($clientId);
            $pwd = '';
            if (array_key_exists(SessionKeys::PWD, $session)) {
                $pwd = $session[SessionKeys::PWD];
            }

           //获取一次设备信息
            $this->getInfo($clientId, $did, $pwd);
        }
    }

    private function setRegisterAddr(){
        Gateway::$registerAddress = ServerAddress::REGISTER_IP . ":1246";
    }

    public function getInfo($client_id,$did, $pwd=''){
        if(empty($pwd)){
            $pwd = $this->getDevicePwd($did);
        }
        if (empty($pwd)) return;
        $req = new PetFeederDeviceInfoReq();
        $req->setSn($this->getSn());
        $data = Des::encrypt($req->toDataArray(), $pwd);
        $this->setRegisterAddr();
        Gateway::sendToClient($client_id,$data);
    }

    protected function getDevicePwd($did){
        $result = (new PetFeederDeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }

    public function deviceInfo()
    {
        // TODO: Implement deviceInfo() method.
    }

    public function firmwareUpdate()
    {
        // TODO: Implement firmwareUpdate() method.
    }
}