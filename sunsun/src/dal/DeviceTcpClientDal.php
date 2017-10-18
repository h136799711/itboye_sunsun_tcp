<?php

namespace sunsun\dal;

use sunsun\model\BaseModel;
use sunsun\model\DeviceTcpClientModel;
use sunsun\server\interfaces\BaseDalV2;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class DeviceTcpClientDal extends BaseDalV2
{
    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->setTableName("sunsun_device_tcp_client");
    }

    public function updateByDid($did, $entity)
    {
        return self::$db->update($this->tableName)->cols($entity)->where(" did= '$did' ")->query();
    }

    public function getInfoByClientId($tcp_client_id)
    {
        return self::$db->select("`id`, `did`, `tcp_client_id`, `prev_login_time`")->from($this->tableName)->where(" tcp_client_id= '$tcp_client_id' ")->row();
    }

    public function getInfoByDid($did)
    {
        return self::$db->select("`id`, `did`, `tcp_client_id`")->from($this->tableName)->where(" did= '$did' ")->row();
    }

    public function logoutByClientId($tcp_client_id)
    {
        $sql = "UPDATE `sunsun_device_tcp_client` SET `tcp_client_id` = '' ";
        $sql .= "WHERE  `tcp_client_id`='$tcp_client_id'";
        $row_count = self::$db->query($sql);
        return $row_count;
    }

    public function insert(BaseModel $do)
    {
        if ($do instanceof DeviceTcpClientModel) {
            self::$db->insert($this->tableName)->cols(array(
                'did' => $do->getDid(),
                'tcp_client_id' => $do->getTcpClientId(),
                'prev_login_time' => $do->getPrevLoginTime()))->query();
        }
    }
}