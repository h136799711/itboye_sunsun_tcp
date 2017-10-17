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
$worker->name = 'adt_worker';
$worker->eventHandler = "\sunsun\server\business\Events";
// bussinessWorker进程数量
$worker->count = 4;
// 服务注册地址
$worker->registerAddress = '127.0.0.1:1242';
// 进程启动时设置一个定时器，定时向所有客户端连接发送数据
$worker->onWorkerStart = function ($worker) {
    // 定时，每10秒一次，
    //todo: 检查是否客户端超时
//    \Workerman\Lib\Timer::add(10, function()use($worker)
//    {
//        // 遍历当前进程所有的客户端连接，发送当前服务器的时间
//        foreach($worker->connections as $connection)
//        {
//            //
//        }
//    });
};
// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

