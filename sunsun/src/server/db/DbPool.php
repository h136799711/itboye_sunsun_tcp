<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-10
 * Time: 15:26
 */

namespace sunsun\server\db;


use sunsun\server\consts\DeviceType;
use Workerman\MySQL\Connection;


define("SUNSUN_WORKER_HOST", "rm-bp1utkoj82w47hlam.mysql.rds.aliyuncs.com");
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
    protected $dbList;

    /**
     * DbPool constructor.
     * @param $dbList
     */
    public function __construct()
    {
        $this->dbList = [];
        array_push($this->dbList, new Connection(SUNSUN_WORKER_HOST, SUNSUN_WORKER_PORT, SUNSUN_WORKER_USER, SUNSUN_WORKER_PASSWORD,SUNSUN_WORKER_DB_NAME));
//        array_push($this->dbList, new Connection(SUNSUN_WORKER_HOST, SUNSUN_WORKER_PORT, SUNSUN_WORKER_USER, SUNSUN_WORKER_PASSWORD,SUNSUN_WORKER_DB_NAME));
        //array_push($this->dbList, new Connection(SUNSUN_WORKER_HOST, SUNSUN_WORKER_PORT, SUNSUN_WORKER_USER, SUNSUN_WORKER_PASSWORD,SUNSUN_WORKER_DB_NAME));
    }


    public static function getInstance(){
        if(self::$dbPool == null){
            self::$dbPool = new DbPool();
//            self::$dbPool->setDb(new Connection(SUNSUN_WORKER_HOST, SUNSUN_WORKER_PORT, SUNSUN_WORKER_USER, SUNSUN_WORKER_PASSWORD, SUNSUN_WORKER_DB_NAME));
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
        return $this->randDb();
//        $type = substr($did,0,3);
//        return $this->getDbByType($type);
    }
    /**
     * 根据type获取指定的数据库链接
     * @param $type
     * @return mixed
     */
    public function getDbByType($type){
        switch ($type){
            case DeviceType::Did_FilterVat:
                break;
            case DeviceType::Did_HeatingRod:
                break;
            case DeviceType::Did_AQ806:
                break;
            case DeviceType::Did_APH300:
                break;
            case DeviceType::Did_WaterPump:
                break;
            case DeviceType::Did_ADT:
                break;
            case DeviceType::Did_CP1000:
                break;
            case DeviceType::Did_AQ118:
                break;
            case DeviceType::Did_Feeder:
                break;
            default:
                break;
        }
        return $this->db;
    }

    /**
     * 获取全局数据库链接
     * @return mixed
     */
    public function getGlobalDb(){
        return $this->randDb();
    }


    protected function randDb() {
        if (count($this->dbList) == 1) {
            $index = 0;
        } elseif (count($this->dbList) > 1) {
            $index = (int) rand(0, count($this->dbList));
            if ($index >= count($this->dbList)) {
                $index = count($this->dbList) - 1;
            }
        } else {
            return null;
        }
        return $this->dbList[$index];
    }
}