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

// php k8290 0 1

// 设置为当前脚本目录
chdir(dirname(__FILE__));
$start = 0;
$size = 1;
//if (count($argv) >= 2) {
//    $start = $argv[1];
//}
//if (count($argv) >= 3) {
//    $size = $argv[2];
//}
define('START', $start);
define('SIZE', $size);
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

function initClients()
{
    $ports = [];
    $fileName = 'k8290.txt';
    if (file_exists($fileName)) {
        $f = fopen($fileName, "r");
        $cnt = 0;
        while (!feof($f)) {
            $line = trim(fgets($f));
            $lineData = explode(' ', $line);
            $types = getTypeBy($lineData[0]);
            $data = [
                'did' => trim($lineData[0]),
                'pwd' => trim($lineData[1]),
                'ctrlPwd' => '12345678',
                'hbType' => $types[0],
                'loginType' => $types[1]
            ];
            array_push($ports, $data);
            $cnt++;
        }
        fclose($f);
    } else {
        echo($fileName . ' not exist');
    }

    return $ports;
}

function getTypeBy($did)
{
    $type = substr($did, 0, 3);
    echo $type;
    switch ($type) {
        case "S01":// filter_vat
            return [2, 1];
        case "S02":// heating_rod
            return [102, 101];
        case "S03":// aq806
            return [302, 301];
        case "S04":// aph300
            return [402, 401];
        case "S05":// 变频水泵
            return [202, 201];
        case "S06":// adt
            return [502, 501];
        case "S13":// adt
            return [1302, 1301];
        case "S14":// 宠物
            return [1402, 1401];
        default:
            break;
    }

    return [];
}

function createByDid($one)
{
    $remoteAddress = "tcp://101.37.37.167:8290";
    $did = $one['did'];
    $type = substr($did, 0, 3);
    $tcpDevice = null;
    switch ($type) {
        case "S01":// 过滤桶
            $tcpDevice = createTcp(new FilterDevice($remoteAddress, null, $one));
            break;
        case "S02":// aq806
            $tcpDevice = createTcp(new HeatingDevice($remoteAddress, null, $one));
            break;
        case "S03":// aq806
            $tcpDevice = createTcp(new Aq806Device($remoteAddress, null, $one));
            break;
        case "S04":// aph300
            $tcpDevice = createTcp(new Aph300Device($remoteAddress, null, $one));
            break;
        case "S05":// 变频水泵
            $tcpDevice = createTcp(new TcpDevice('tcp://s13.sunsunxiaoli.com:8303', null, $one));
            break;
        case "S06":// adt
            $tcpDevice = createTcp(new AdtDevice($remoteAddress, null, $one));
            break;
        case "S13":// aq136
            $tcpDevice = createTcp(new TcpDevice('tcp://master.sunsunxiaoli.com:8303', null, $one));
            break;
        case "S14":// aq136
            $tcpDevice = createTcp(new TcpDevice('tcp://master.sunsunxiaoli.com:8304', null, $one));
            break;
        default:
            break;
    }

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
    $start = START;
    $size = SIZE;
    $clients = initClients();

    $sockets = [];
    if (count($clients) < $size) {
        echo('option size can\'t bigger than clients size');
        return;
    }

    for ($i = 0; $i < $size; $i++) {
        $one = $clients[$i + $start];
        $tcpDevice = createByDid($one);
        if ($tcpDevice == null) {
            var_dump($one);
            echo 'empty';
            continue;
        }
        array_push($sockets, $tcpDevice);
    }

    Timer::add(1, function () use ($sockets, $size) {
        for ($i = 0; $i < $size; $i++) {
            $tcpDevice = $sockets[$i];
            if ($tcpDevice instanceof TcpDevice) {
                $tcpDevice->heartBeat();
                echo "发送心跳","\n";
            } else {
                echo "心跳失败","\n";
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
