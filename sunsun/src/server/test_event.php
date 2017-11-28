<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * @author    hebidu<346551990@qq.com>
 * @copyright 2017 www.itboye.com Boye Inc. All rights reserved.
 * @link      http://www.itboye.com/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-11-25 14:56
 *********************************
 ********1.0.1********************
 *
 *********************************
 */


// 自动加载类
require_once __DIR__ . '/../../../vendor/autoload.php';


$producer = new \sunsun\server\mq\producer\EventProducer(new \byCli\mq\DefaultMQConfig());
$producer->init();
$cnt = 10;
while ($cnt--) {
    echo 'send ' . $cnt, "\n";
    $producer->send(date('Y-m-d H:i:s') . ' test ');
    sleep(3);
}
$producer->close();
$producer = null;