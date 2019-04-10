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
$gateway = new Gateway("\sunsun\SunsunV1://0.0.0.0:8303");
// gateway名称，status方便查看,过滤桶
$gateway->name = 'aq136_gateway';
// gateway进程数
$gateway->count = 5;
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp =  \sunsun\ServerAddress::SLAVE_01_INNER_IP;
// 内部通讯起始端口，假如$gateway->count=4，起始端口为3900
// 则一般会使用 4个端口作为内部通讯端口
$gateway->startPort = 5030;
// 服务注册地址
$gateway->registerAddress = \sunsun\ServerAddress::MASTER_INNER_IP . ':1255';

// 心跳间隔
$gateway->pingInterval = 0;

$gateway->pingNotResponseLimit = 0;

$gateway->pingData = '';


// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

