<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-18
 * Time: 11:13
 */

namespace sunsun\server\interfaces;


use sunsun\model\BaseModel;
use sunsun\server\business\DebugEvents;
use sunsun\server\business\Events;
use Workerman\MySQL;

abstract class BaseDalV2
{

    /**
     * @var MySQL\Connection
     *
     * User: ${USER}
     * Date: ${DATE}
     * Time: ${TIME}
     */
    public static $db;

    protected $tableName = '';

    public function __construct($db = null)
    {
        if ($db instanceof MySQL\Connection) {
            self::$db = $db;
        } else {
            if (class_exists('Events')) {
                self::$db = Events::getDb();
            } elseif (class_exists('DebugEvents')) {
                self::$db = DebugEvents::getDb();
            }
        }
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    public function clearAll()
    {
        $this->truncateTable($this->tableName);
    }

    public function truncateTable($tableName)
    {
        return self::$db->query("TRUNCATE TABLE " . $tableName);
    }

    public function getLastSql()
    {
        return self::$db->lastSQL();
    }

    public function isTableExist($tableName)
    {
        return self::$db->query("select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA = '" . SUNSUN_WORKER_DB_NAME . "' and TABLE_NAME='$tableName' ");
    }

    public function insert(BaseModel $do)
    {
        self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

    public function updateByDid($did, $entity)
    {
        return self::$db->update($this->tableName)->cols($entity)->where(" did= '$did' ")->query();
    }

    public function getInfoByDid($did)
    {
        return self::$db->select("`id`, `did`, `ver`, `pwd`, `last_login_time`, `hb`, `tcp_client_id`, `last_login_ip`, `create_time`, `update_time`")->from($this->tableName)->where(" did= '$did' ")->row();
    }

    public function logoutByClientId($tcp_client_id)
    {
        $sql = "UPDATE `" . $this->tableName . "` SET `tcp_client_id` = '' ";
        $sql .= "WHERE  `tcp_client_id`='$tcp_client_id'";
        $row_count = self::$db->query($sql);
        return $row_count;
    }

    public function loginByTcpClientId($tcp_client_id, $loginIp)
    {
        $result = $this->getInfoByClientId($tcp_client_id);
        if ($result === false) return false;
        $id = $result['id'];
        $entity = [];
        $entity['update_time'] = time();
        $this->update($id, $entity);
        return $result;
    }

    public function getInfoByClientId($tcp_client_id)
    {
        return self::$db->select("`id`, `did`, `ver`, `pwd`, `last_login_time`, `hb`, `tcp_client_id`, `last_login_ip`, `create_time`, `update_time`")->from($this->tableName)->where(" tcp_client_id= '$tcp_client_id' ")->row();
    }

    public function update($id, $entity)
    {
        return self::$db->update($this->tableName)->cols($entity)->where('id=' . $id)->query();
    }

    /**
     * 批量插入
     * @param array $data 数据，键的顺序需要对于列
     * @param array $cols 列
     * @return mixed
     */
    public function insertAll($data, $cols)
    {
        $sql = '';

        for ($i = 0; $i < count($cols); $i++) {
            if ($i > 0) {
                $sql .= ", ";
            }
            $sql .= "`" . $cols[$i] . "`";
        }

        if (strlen($sql) > 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "`(" . $sql . ")";
        } else {
            $sql = "INSERT INTO `" . $this->getTableName() . "`";
        }
        $sql .= " VALUES";
        $rowSql = '';
        for ($k = 0; $k < count($data); $k++) {
            $row = $data[$k];
            if ($k > 0) {
                $rowSql .= ", ";
            }
            $rowSql .= "(";
            for ($j = 0; $j < count($cols); $j++) {
                if ($j > 0) {
                    $rowSql .= ", ";
                }
                $rowSql .= '"' . strval($row[$cols[$j]]) . '"';
            }
            $rowSql .= ")";
        }
        $sql .= ' ' . $rowSql . ';';
        return self::$db->query($sql);
    }
}