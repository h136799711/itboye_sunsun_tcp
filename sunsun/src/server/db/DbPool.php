<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-10
 * Time: 15:26
 */

namespace sunsun\server\db;


use Workerman\MySQL\Connection;

define("SUNSUN_WORKER_HOST", "101.37.37.167");
define("SUNSUN_WORKER_PORT", "3306");
define("SUNSUN_WORKER_USER", "sunsun");
define("SUNSUN_WORKER_PASSWORD", "poiuyTREWQ123456");
define("SUNSUN_WORKER_DB_NAME", "sunsun_xiaoli");

/**
 * Class DbPool
 * 数据库池
 * TODO: 增加多个数据库链接根据设备类型选择不同的连接，目前只用一个
 * @package sunsun\server\db
 */
class DbPool
{
    protected $db;
    private static $dbPool = null;

    public static function getInstance(){
        if(self::$dbPool == null){
            self::$dbPool = new DbPool();
            self::$dbPool->setDb(new Connection(SUNSUN_WORKER_HOST, SUNSUN_WORKER_PORT, SUNSUN_WORKER_USER, SUNSUN_WORKER_PASSWORD, SUNSUN_WORKER_DB_NAME));
        }
        return self::$dbPool;
    }

    public function setDb($db){
        $this->db = $db;
    }

    /**
     * 根据did获取指定的数据库链接
     * @param $did
     * @return mixed
     */
    public function getDb($did){
        return $this->db;
    }

    /**
     * 获取全局数据库链接
     * @return mixed
     */
    public function getGlobalDb(){
        return $this->db;
    }
}