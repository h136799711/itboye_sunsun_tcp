<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-09
 * Time: 10:51
 */

namespace sunsun\tcp_client;

use Workerman\Lib\Timer;
use Workerman\Worker;

require_once __DIR__ . '/../../../vendor/autoload.php';

// 设置为当前脚本目录
chdir(dirname(__FILE__));

function createTcp($tcpDevice){

    $tcpDevice->onConnect = function($tcpDevice)
    {
        $tcpDevice->login();
    };
    $tcpDevice->onMessage = function($tcpDevice, $http_buffer)
    {
        $tcpDevice->message($http_buffer);
    };
    $tcpDevice->onClose = function($tcpDevice)
    {
        echo "close";
        $tcpDevice->reConnect(5);
    };
    $tcpDevice->onError = function($tcpDevice, $code, $msg)
    {
        echo "Error code:$code msg:$msg\n";
    };
    $tcpDevice->connect();
    return $tcpDevice;
}

function initClients(){

    $ports = [
        'k8181'=>[]
    ];

    foreach ($ports as $key=>&$value){
        $fileName = ($key.'.txt');
        if(file_exists($fileName)){
            $f= fopen($fileName,"r");
            $cnt = 0;
            $hbType='';
            $type='';
            $pwd='';
            while (!feof($f))
            {
                $line = fgets($f);
                $lineData = explode(' ', $line);
                if($cnt == 0){
                    $hbType = $lineData[0];
                    $type = $lineData[1];
                    $pwd =  $lineData[2];
                }else{
                    $data = [
                        'did'=>$lineData[0],
                        'pwd'=>$lineData[1],
                        'ctrlPwd'=>$pwd,
                        'hbType'=>$hbType,
                        'loginType'=>$type
                    ];
                    array_push($value,$data);
                }
                $cnt++;
            }
            fclose($f);
        }else {
            echo ($fileName.' not exist');
        }
    }
    return $ports;
}

$task = new Worker();
$task->onClose = function ($connection){
    echo 'onClose';
};
$task->onError = function($connection, $code, $msg)
{
    echo "error $code $msg\n";
};
// 进程启动时异步建立一个到www.baidu.com连接对象，并发送数据获取数据
$task->onWorkerStart = function($task)
{
    $start = 0;//$input->getOption('start');
    $size = 1;//$input->getOption('size');
    $portClients = initClients();
    $time = microtime(true);
    $port = 8181;//$input->getOption('port');
    $times = 5*3600;//在线时间 秒
    $sockets = [];
    $size = 500;
    $clients = $portClients['k' . $port];
    for($i=0;$i<$size;$i++) {
        $one = $clients[$i + $start];
        $tcpDevice = createTcp(new Aq806Device('tcp://hebidu.cn:'.$port,null, $one));
        array_push($sockets,$tcpDevice);
    }
    Timer::add(3,function() use ($sockets,$size) {
        for($i=0;$i<$size;$i++){
            $tcpDevice  = $sockets[$i];
            if($tcpDevice instanceof  Aq806Device){
                $tcpDevice->heartBeat();
            }
        }
    });
//    // 定时关闭
//    Timer::add($times,function() use ($sockets,$size) {
//        for($i=0;$i<$size;$i++){
//            $tcpDevice  = $sockets[$i];
//            if($tcpDevice instanceof  TcpDevice){
//                $tcpDevice->logout();
//            }
//        }
//    });
};

// 运行worker
Worker::runAll();