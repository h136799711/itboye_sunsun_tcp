<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 09:47
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\aq118\dal\Aq118DeviceDal;
use sunsun\aq118\req\Aq118DeviceInfoReq;
use sunsun\decoder\SunsunTDS;
use sunsun\transfer_station\interfaces\DeviceClientInterface;


class Aq118Client extends BaseClient implements DeviceClientInterface
{
    public function updateAppCnt($did, $cnt = 0)
    {
        $this->setRegisterAddr();
        $clientIds = Gateway::getClientIdByUid($did);
        if (is_array($clientIds) && count($clientIds) > 0 ) {
            $clientId = $clientIds[0];
            Gateway::updateSession($clientId, ['app_cnt' => $cnt]);
        }
    }

    private function setRegisterAddr(){
        Gateway::$registerAddress = "101.37.37.167:1244";
    }

    public function deviceInfo()
    {
        // TODO: Implement deviceInfo() method.
    }

    public function firmwareUpdate()
    {
        // TODO: Implement firmwareUpdate() method.
    }

    public function getInfo($client_id,$did, $pwd=''){
        if(empty($pwd)){
            $pwd = $this->getDevicePwd($did);
        }
        $req = new Aq118DeviceInfoReq();
        $req->setSn($this->getSn());
        $data = SunsunTDS::encode($req->toDataArray(), $pwd);
        $this->setRegisterAddr();
        $this->staticsDelay($req->getSn(),$client_id);
        Gateway::sendToClient($client_id,$data);
    }

    protected function getDevicePwd($did){
        $result = (new Aq118DeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }
}