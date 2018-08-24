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

// 自动加载类
require_once __DIR__ . '/../../../vendor/autoload.php';

\sunsun\ByGatewayClient::$registerAddress = "master.sunsunxiaoli.com:1238";
// gateway 进程，这里使用Text协议，可以用telnet测试

try {
    $reg = \sunsun\ByGatewayClient::getAllGatewayAddressesFromRegister();
    var_dump($reg);

} catch (Exception $e) {

}
