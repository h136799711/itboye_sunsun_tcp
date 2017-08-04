<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 21:44
 */

namespace sunsun\adt\dal;


use sunsun\adt\model\AdtDeviceModel;
use sunsun\dal\BaseDal;

class AdtDeviceDal extends BaseDal
{
    protected $tableName = "sunsun_adt_device";

    public function insert(AdtDeviceModel $do)
    {
        self::$db->insert($this->tableName)->cols($do->toDataArray())->query();
    }

    public function update($id, $entity)
    {
        return self::$db->update($this->tableName)->cols($entity)->where('id=' . $id)->query();
    }

    public function updateByDid($did, $entity)
    {
        return self::$db->update($this->tableName)->cols($entity)->where(" did= '$did' ")->query();
    }

    public function getInfoByClientId($tcp_client_id)
    {
        return self::$db->select("`id`, `did`, `ver`, `pwd`, `last_login_time`, `hb`, `tcp_client_id`, `last_login_ip`, `create_time`, `update_time`")->from($this->tableName)->where(" tcp_client_id= '$tcp_client_id' ")->row();
    }

    public function getInfoByDid($did)
    {
        return self::$db->select("`id`, `did`, `ver`, `pwd`, `last_login_time`, `hb`, `tcp_client_id`, `last_login_ip`, `create_time`, `update_time`")->from($this->tableName)->where(" did= '$did' ")->row();
    }

    public function logoutByClientId($tcp_client_id)
    {

        $sql = "UPDATE `sunsun_adt_device` SET `tcp_client_id` = '' ";
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

}