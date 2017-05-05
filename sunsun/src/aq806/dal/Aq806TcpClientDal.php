<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:28
 */

namespace sunsun\aq806\dal;


use sunsun\dal\BaseDal;

class Aq806TcpClientDal extends BaseDal
{
    public function insert($client_id){
        self::$db->insert("sunsun_aq806_tcp_client")->cols(['client_id'=>$client_id])->query();
    }

    public function delete($client_id){
        $row_count = self::$db->delete('sunsun_aq806_tcp_client')->where(" client_id= '$client_id' ")->query();
        return $row_count;
    }
    public function update($client_id){
        $sql = "UPDATE `sunsun_aq806_tcp_client` SET `cnt` = `cnt`+1 ";
        $sql .= "WHERE  `client_id`='$client_id'";
        $row_count = self::$db->query($sql);
        return $row_count;
    }

    public function getInfo($client_id){
        return self::$db->select('cnt,client_id,id')->from('sunsun_aq806_tcp_client')->where(" client_id= '$client_id' ")->row();
    }

    public function clearAll(){
        $this->truncateTable("sunsun_aq806_tcp_client");
    }
}