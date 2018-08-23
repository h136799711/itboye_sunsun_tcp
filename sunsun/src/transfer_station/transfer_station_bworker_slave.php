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
$worker->name = 'transfer_worker';
// bussinessWorker进程数量
$worker->count = 8;
//$worker->eventHandler = "\sunsun\transfer_station\events\Transfer";
// 服务注册地址
$worker->registerAddress = \sunsun\ServerAddress::MASTER_INNER_IP.':1250';
// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

