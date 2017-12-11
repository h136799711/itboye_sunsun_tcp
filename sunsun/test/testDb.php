<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * @author    hebidu<346551990@qq.com>
 * @copyright 2017 www.itboye.com Boye Inc. All rights reserved.
 * @link      http://www.itboye.com/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-12-07 10:58
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Workerman\MySQL\Connection;

//
//class  Dal extends \sunsun\server\interfaces\BaseDalV2
//{
//}

$mysqlConn = new Connection("101.37.37.167", "3306", "sunsun", "poiuyTREWQ123456", "sunsun_xiaoli");

//$dal = new Dal($mysqlConn);

//$sql = "INSERT INTO `test` ( `test`)
//values(1),( 2)";
//
//$result = $mysqlConn->query($sql);
//$dal->setTableName('sunsun_water_pump_device_event');
//$info = ['a' => 'b', 'c' => 'd'];
//$data = [
//    ['did' => 'test', 'event_type' => '1', 'event_info' => $info, 'create_time' => '1'],
//    ['did' => 'test1', 'event_type' => '1', 'event_info' => $info, 'create_time' => '1']
//];
//
//$result = $dal->insertAll($data, ["did", "event_type", "event_info", "create_time"]);
//
//
//var_dump($result);
$did = 'S06X0000000003';
(new \sunsun\adt\dal\AdtDeviceDal($mysqlConn))->updateByDidOnline($did);
