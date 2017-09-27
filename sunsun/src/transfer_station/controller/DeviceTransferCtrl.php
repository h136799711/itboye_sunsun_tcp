<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-25
 * Time: 15:52
 */

namespace sunsun\transfer_station\controller;


use GatewayWorker\Lib\Gateway;
use sunsun\helper\LogHelper;
use sunsun\helper\ResultHelper;

class DeviceTransferCtrl
{
    public function process($client_id,$message){
        $jsonDecode = json_decode($message, JSON_OBJECT_AS_ARRAY);
        if($jsonDecode === false){
            return ResultHelper::fail('unknown message');
        }
        LogHelper::logDebug($client_id,json_encode($jsonDecode),'transfer process');
        if(array_key_exists('t',$jsonDecode)){
            $t = $jsonDecode['t'];
            return $this->innerProcess($client_id,strval($t),$jsonDecode);
        }

        return ResultHelper::fail('cant process',[],-101);
    }

    private function innerProcess($client_id,$type,$data){
        switch ($type){
            case ReqMsgType::Hb:
                return $this->hb($client_id,$data);
            case ReqMsgType::Login:
                return $this->login($client_id,$data);
                break;
            case ReqMsgType::SwitchGroup:
                return $this->switchGroup($client_id,$data);
                break;
            default:
                return ResultHelper::fail('unknown message type');
                break;
        }
    }

    private function hb($client_id,$data){
        return ResultHelper::success('100');
    }

    private function login($client_id, $data){
        $did = array_key_exists('did',$data) ? $data['did']:'';
        $pre_did = array_key_exists('pre_did',$data) ? $data['pre_did']:'';
        $token = array_key_exists('token',$data) ? $data['token']:'';
        $uid = array_key_exists('uid',$data) ? $data['uid']:'';
        // TODO token暂时不用
        if(empty($did) || empty($token) || empty($uid)){
            return ResultHelper::fail('did|token|uid invalid');
        }
        if(!empty($pre_did)){
            Gateway::leaveGroup($client_id, $pre_did);
        }
        // client_id 加入到 did
        Gateway::joinGroup($client_id,$did);
        return ResultHelper::success('login success');
    }

}