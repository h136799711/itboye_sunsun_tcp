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

function createTcp($tcpDevice)
{

    $tcpDevice->onConnect = function ($tcpDevice) {
        $tcpDevice->login();
    };
    $tcpDevice->onMessage = function ($tcpDevice, $http_buffer) {
        $tcpDevice->message($http_buffer);
    };
    $tcpDevice->onClose = function ($tcpDevice) {
        $tcpDevice->reConnect(10);
    };
    $tcpDevice->onError = function ($tcpDevice, $code, $msg) {
        echo "Error code:$code msg:$msg\n";
    };
    $tcpDevice->connect();
    return $tcpDevice;
}

$task = new Worker();
$task->onClose = function ($connection) {
    echo 'onClose';
};
$task->onError = function ($connection, $code, $msg) {
    echo "error $code $msg\n";
};
// 进程启动时异步建立一个到www.baidu.com连接对象，并发送数据获取数据
$task->onWorkerStart = function ($task) {
    $tcpDevice = createTcp(new TransferClient('tcp://101.37.37.167:8300', null));

    Timer::add(120, function () use ($tcpDevice) {
        $tcpDevice->heartBeat();
    });
};

// 运行worker
Worker::runAll();