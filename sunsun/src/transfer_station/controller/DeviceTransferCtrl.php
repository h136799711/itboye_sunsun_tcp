<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-25
 * Time: 15:52
 */

namespace sunsun\transfer_station\controller;


use GatewayWorker\Lib\Gateway;
use sunsun\helper\ResultHelper;
use sunsun\transfer_station\client\FactoryClient;
use sunsun\transfer_station\interfaces\DeviceClientInterface;

class DeviceTransferCtrl implements DeviceClientInterface
{
    private $client_id;
    private $data;

    public function process($client_id,$message){
        $jsonDecode = json_decode($message, JSON_OBJECT_AS_ARRAY);
        if($jsonDecode === false){
            return ResultHelper::fail('unknown message');
        }
        if(array_key_exists('t',$jsonDecode)){
            $t = $jsonDecode['t'];
            return $this->innerProcess($client_id,strval($t),$jsonDecode);
        }

        return ResultHelper::fail('cant process',[],-101);
    }

    private function innerProcess($client_id,$type,$data){
        $this->client_id = $client_id;
        $this->data = $data;
        switch ($type){
            case ReqMsgType::Hb:
                return $this->hb();
            case ReqMsgType::Login:
                return $this->login();
                break;
            case ReqMsgType::FirmwareUpdate:
                return $this->firmwareUpdate();
                break;
            default:
                return ResultHelper::fail('unknown message type');
                break;
        }
    }

    private function hb()
    {
        return ResultHelper::success('100');
    }

    private function login()
    {

        $did = array_key_exists('did', $this->data) ? $this->data['did'] : '';
        $pre_did = array_key_exists('pre_did', $this->data) ? $this->data['pre_did'] : '';
        $token = array_key_exists('token', $this->data) ? $this->data['token'] : '';
        $uid = array_key_exists('uid', $this->data) ? $this->data['uid'] : '';
        //
        if (!empty($pre_did)) {
            Gateway::leaveGroup($this->getClientId(), $pre_did);
            if (empty($did)) {
                return ResultHelper::success('logout success');
            }
        }
        // TODO token暂时不用
        if (empty($did) || empty($token)) {
            return ResultHelper::fail('did|token|uid invalid');
        }

        // 更新在线设备数
        $this->updateAppCnt($did);

        // client_id 加入到 did
        Gateway::joinGroup($this->getClientId(), $did);
        return ResultHelper::success('login success');
    }

    public function updateAppCnt($did, $cnt = 0)
    {
        $cnt = Gateway::getClientCountByGroup($did);
        FactoryClient::updateAppCnt($did, $cnt);
    }

    public function deviceInfo()
    {
        // TODO implements
    }

    /**
     * 固件更新
     * @return array
     */
    public function firmwareUpdate()
    {
        return $this->getDeviceClientBy()->firmwareUpdate();
    }

    private function getDeviceClientBy()
    {
        $did = $this->getDidBy($this->getClientId());
        return FactoryClient::createClient($did);
    }

    private function getDidBy($client_id)
    {
        $session = Gateway::getSession($client_id);
        if (array_key_exists('did', $session)) {
            return $session['did'];
        }
        return '';
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

}