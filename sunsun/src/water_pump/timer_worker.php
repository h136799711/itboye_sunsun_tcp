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

use GatewayWorker\BusinessWorker;
use Workerman\Worker;

define("SUNSUN_ENV", "debug");//debug|production 模式
// 自动加载类
require_once __DIR__ . '/../../../vendor/autoload.php';


// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = 'water_pump_timer_worker';
// bussinessWorker进程数量
$worker->count = 1;
$worker->eventHandler = "\sunsun\server\business\TimerEvents";
// 服务注册地址
$worker->registerAddress = '127.0.0.1:1241';
// 进程启动时设置一个定时器，定时向所有客户端连接发送数据

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
