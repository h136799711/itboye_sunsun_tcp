<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 09:50
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\server\consts\SessionKeys;
use sunsun\ServerAddress;
use sunsun\transfer_station\interfaces\DeviceClientInterface;
use sunsun\water_pump\dal\WaterPumpDeviceDal;
use sunsun\water_pump\req\WaterPumpDeviceInfoReq;

class WaterPumpClient extends BaseClient implements DeviceClientInterface
{
    private static $instance = null;

    public function updateAppCnt($did, $cnt = 0)
    {

        $this->setRegisterAddr();
        $clientIds = Gateway::getClientIdByUid($did);
        if (is_array($clientIds) && count($clientIds) > 0 ) {
            $clientId = $clientIds[0];
            Gateway::updateSession($clientId, ['app_cnt' => $cnt]);
            $session = Gateway::getSession($clientId);

            $pwd = '';
            if (array_key_exists(SessionKeys::PWD, $session)) {
                $pwd = $session[SessionKeys::PWD];
            }

            if (!empty($pwd)) {
                //获取一次设备信息
                $this->getInfo($clientId, $did, $pwd);
            }
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new WaterPumpClient();
        }
        return self::$instance;
    }
    public function getInfo($client_id, $did, $pwd = '')
    {
        if (empty($pwd)) {
            $pwd = $this->getDevicePwd($did);
        }
        $req = new WaterPumpDeviceInfoReq();
        $req->setSn($this->getSn());
        $data = $this->getEncryptPacketStr($req, $pwd);
        $this->setRegisterAddr();
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
        Gateway::$registerAddress = ServerAddress::REGISTER_IP . ":1241";
    }

    protected function getDevicePwd($did){
        $result = (new WaterPumpDeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }
}