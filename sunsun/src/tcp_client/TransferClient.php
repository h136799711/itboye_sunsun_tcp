<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-09
 * Time: 12:27
 */

namespace sunsun\tcp_client;


use Workerman\Connection\AsyncTcpConnection;

class TransferClient extends AsyncTcpConnection
{

    const ReconnectMax = 10;// 最大重连次数
    public $isLogined;
    public $reconnectCnt = 0;// 当前重连次数

    public function message($msg)
    {
        echo $msg;
    }

    public function __construct($remote_address, $context_option = null)
    {
        parent::__construct($remote_address, $context_option);
    }


    /**
     * 登录请求
     */
    public function login()
    {
        $this->isLogined = false;
        $entity = [
            't' => "101",
            'pre_did' => "",
            'did' => "hebidu",
            'token' => '1235456',
            'uid' => "101"
        ];
        $sendData = json_encode($entity);
        $this->send($sendData);
    }

    /**
     * 关闭通道
     */
    public function logout()
    {
        $this->isLogined = false;
        $entity = [
            't' => "101",
            'pre_did' => "hebidu",
            'did' => "",
            'token' => '1235456',
            'uid' => "101"
        ];
        $sendData = json_encode($entity);
        $this->send($sendData);
        $this->close();
    }

    /**
     * 心跳
     */
    public function heartBeat()
    {
        if (!$this->isLogined) {
            $this->login();
        } else {
            $entity = [
                't' => "100"
            ];
            $sendData = json_encode($entity);
            $this->send($sendData);
        }
    }

    public function reConnect($after = 0)
    {
        if ($this->reconnectCnt > TcpDevice::ReconnectMax) {
            $this->logout();
        }
        parent::reConnect($after);
        $this->reconnectCnt++;
    }

}