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

// 自动加载类
require_once __DIR__ . '/../../../vendor/autoload.php';


// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = 'aq118_worker';
// bussinessWorker进程数量
$worker->count = 4;
// 设置业务处理类
$worker->eventHandler = "\sunsun\server\business\Events";
// 服务注册地址
$worker->registerAddress = '172.16.23.85:1244';
// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

