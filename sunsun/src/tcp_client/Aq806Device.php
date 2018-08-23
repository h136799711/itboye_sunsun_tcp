<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-09
 * Time: 12:27
 */

namespace sunsun\tcp_client;


use sunsun\decoder\SunsunTDS;
use Workerman\Connection\AsyncTcpConnection;

class Aq806Device extends AsyncTcpConnection
{

    const ReconnectMax = 10;// 最大重连次数
    public $publicPwd = '1234bcda';
    public $did;
    public $pwd;
    public $ctrlPwd;
    public $hbType;
    public $loginType;
    public $hbSeconds = 90;//心跳间隔 s
    public $sn=0;
    public $isLogined;
    public $reconnectCnt = 0;// 当前重连次数

    public function message($msg){
//        if($this->isLogined){
        $decode = SunsunTDS::decode($msg, $this->pwd);
//        }else{
//            $decode = SunsunTDS::decode($msg, $this->publicPwd);
//        }
//        echo $msg;
        if($decode->isValid()){
            $data = $decode->getTdsData();
//            var_dump($data);
            $orginData = $decode->getTdsOriginData();
//            var_dump($orginData);
            if(is_string($orginData)){
                $orginData = json_decode($orginData, JSON_OBJECT_AS_ARRAY);
            }
            var_dump($orginData);
            if(is_array($orginData)){
                if(array_key_exists('resType',$orginData)){
                    $resType = $orginData['resType'];
                    if($resType == '301'){
                        echo 'login';
                        $this->isLogined  = true;
                    }
                }elseif(array_key_exists('resType',$orginData)){
                    $reqType = $orginData['reqType'];
                }else{
                    echo '非法数据';
                }
            }
        }else{
            echo '非法数据';
        }
    }

    public function __construct($remote_address, $context_option = null, $deviceInfo=[])
    {
        parent::__construct($remote_address, $context_option);
        $this->did = $deviceInfo['did'];
        $this->pwd = $deviceInfo['pwd'];
        $this->ctrlPwd = $deviceInfo['ctrlPwd'];
        $this->hbType = $deviceInfo['hbType'];
        $this->loginType = $deviceInfo['loginType'];
    }


    /**
     * 登录请求
     */
    public function login(){
        $this->isLogined = false;
        $pwd  = SunsunTDS::encodePwd($this->ctrlPwd, $this->pwd);
        $entity = [
            'reqType'=>$this->loginType,
            'sn'=>rand(10000,99999),
            'did'=>$this->did,
            'ver'=>'V1.0',
            'pwd'=>base64_decode($pwd)
        ];
        $sendData = SunsunTDS::encode($entity, $this->publicPwd);
        $this->send($sendData);
    }

    /**
     * 关闭通道
     */
    public function logout(){
        $this->close();
    }

    /**
     * 心跳
     */
    public function heartBeat(){
        if(!$this->isLogined){
            $this->login();
        }else{
            $entity = [
                'reqType'=>$this->hbType,
                'sn'=>($this->sn++)
            ];
            $sendData = SunsunTDS::encode($entity, $this->pwd);
            $this->send($sendData);
        }
    }

    public function reConnect($after=0){
        if($this->reconnectCnt > TcpDevice::ReconnectMax){
            $this->logout();
        }
        parent::reConnect($after);
        $this->reconnectCnt++;
    }

}