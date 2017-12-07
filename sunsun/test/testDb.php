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

class  Dal extends \sunsun\server\interfaces\BaseDalV2
{

    public function insertAll($data, $cols = [])
    {
        $sql = '';
        if (!empty($cols)) {
            for ($i = 0; $i < count($cols); $i++) {
                if ($i > 0) {
                    $sql .= ", ";
                }
                $sql .= "`" . $cols[$i] . "`";
            }
        }
        if (strlen($sql) > 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "`(" . $sql . ")";
        } else {
            $sql = "INSERT INTO `" . $this->getTableName() . "`";
        }
        echo $sql, "\n";
        $sql .= " VALUES";
        $rowSql = '';
        for ($k = 0; $k < count($data); $k++) {
            $row = $data[$k];
            if ($k > 0) {
                $rowSql .= ", ";
            }
            $rowSql .= "(";
            for ($j = 0; $j < count($row); $j++) {
                if ($j > 0) {
                    $rowSql .= ", ";
                }
                $rowSql .= strval($row[$j]);
            }
            $rowSql .= ")";
        }
        echo "full sql statement", "\n";
        $sql .= ' ' . $rowSql . ';';
        echo $sql, "\n";

        return self::$db->query($sql);
    }
}

$mysqlConn = new Connection("101.37.37.167", "3306", "sunsun", "poiuyTREWQ123456", "sunsun_sales");

$dal = new Dal($mysqlConn);

//$sql = "INSERT INTO `test` ( `test`)
//values(1),( 2)";
//
//$result = $mysqlConn->query($sql);
$dal->setTableName('test');

$result = $dal->insertAll([['11'], ['22'], ['33']], ['test']);


var_dump($result);
