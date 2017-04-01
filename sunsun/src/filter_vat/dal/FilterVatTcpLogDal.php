<?php

namespace sunsun\filter_vat\dal;

use sunsun\dal\BaseDal;
use sunsun\filter_vat\model\FilterVatTcpLogModel;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 12:16
 */
class FilterVatTcpLogDal extends BaseDal
{
    protected $tableName = "sunsun_filter_vat_tcp_log";

    public function insert(FilterVatTcpLogModel $do){
        self::$db->insert($this->tableName)->cols(array(
            'owner'=>$do->getOwner(),
            'body'=>$do->getBody(),
            'level'=>$do->getLevel(),
            'type'=>$do->getType(),
            'create_time'=>$do->getCreateTime()))->query();
    }

    public function clearAll(){
        $this->truncateTable($this->tableName);
    }
}