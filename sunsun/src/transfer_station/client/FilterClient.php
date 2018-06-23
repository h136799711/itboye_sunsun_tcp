<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 09:47
 */

namespace sunsun\transfer_station\client;

use GatewayClient\Gateway;
use sunsun\decoder\SunsunTDS;
use sunsun\filter_vat\dal\FilterVatDeviceDal;
use sunsun\filter_vat\req\FilterVatDeviceInfoReq;
use sunsun\server\consts\SessionKeys;
use sunsun\transfer_station\interfaces\DeviceClientInterface;

class FilterClient extends BaseClient implements DeviceClientInterface
{
    public function deviceInfo()
    {
        // TODO: Implement deviceInfo() method.
    }

    public function firmwareUpdate()
    {
        // TODO: Implement firmwareUpdate() method.
    }

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

    private  function setRegisterAddr(){
        Gateway::$registerAddress = "101.37.37.167:1237";
    }

    public function getInfo($client_id,$did, $pwd=''){
        if(empty($pwd)){
            $pwd = $this->getDevicePwd($did);
        }
        $req = new FilterVatDeviceInfoReq();
        $req->setSn($this->getSn());
        $data = SunsunTDS::encode($req->toDataArray(), $pwd);
        $this->setRegisterAddr();
        $this->staticsDelay($req->getSn(),$client_id);
        Gateway::sendToClient($client_id,$data);
    }

    protected function getDevicePwd($did){
        $result = (new FilterVatDeviceDal())->getInfoByDid($did);
        if (empty($result)) {
            return '';
        }
        return $result['pwd'];
    }
}