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
$gateway = new Gateway("tcp://0.0.0.0:8284");
// gateway名称，status方便查看,过滤桶
$gateway->name = 'server_aq806_gateway';
// gateway进程数
$gateway->count = 4;
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp = '101.37.37.167';
// 内部通讯起始端口，假如$gateway->count=4，起始端口为 4740
// 则一般会使用 4个端口作为内部通讯端口
$gateway->startPort = 4770;
// 服务注册地址
$gateway->registerAddress = '127.0.0.1:1212';

// 心跳间隔
$gateway->pingInterval = 20;

$gateway->pingNotResponseLimit = 12;

$gateway->pingData = '';

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

