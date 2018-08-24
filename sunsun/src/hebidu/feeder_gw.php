<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

use GatewayWorker\Gateway;
use Workerman\Worker;

// 自动加载类
require_once __DIR__ . '/../../../vendor/autoload.php';

// gateway 进程，这里使用Text协议，可以用telnet测试
$gateway = new Gateway("tcp://0.0.0.0:8290");
// gateway名称，status方便查看,过滤桶
$gateway->name = 'feeder_gateway';
// gateway进程数
$gateway->count = 4;
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp =  '172.24.72.11';
// 内部通讯起始端口，假如$gateway->count=4，起始端口为3900
// 则一般会使用 4个端口作为内部通讯端口
$gateway->startPort = 3410;
// 服务注册地址
$gateway->registerAddress = '127.0.0.1:1238';

// 心跳间隔
$gateway->pingInterval = 360;

$gateway->pingNotResponseLimit = 1;

$gateway->pingData = '';


/* 
// 当客户端连接上来时，设置连接的onWebSocketConnect，即在websocket握手时的回调
$gateway->onConnect = function($connection)
{
    $connection->onWebSocketConnect = function($connection , $http_header)
    {
        // 可以在这里判断连接来源是否合法，不合法就关掉连接
        // $_SERVER['HTTP_ORIGIN']标识来自哪个站点的页面发起的websocket链接
        if($_SERVER['HTTP_ORIGIN'] != 'http://kedou.workerman.net')
        {
            $connection->close();
        }
        // onWebSocketConnect 里面$_GET $_SERVER是可用的
        // var_dump($_GET, $_SERVER);
    };
}; 
*/

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

