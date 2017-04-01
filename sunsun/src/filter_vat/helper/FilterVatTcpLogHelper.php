<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-14
 * Time: 15:17
 */

namespace sunsun\filter_vat\helper;


use sunsun\filter_vat\dal\FilterVatTcpLogDal;
use sunsun\filter_vat\model\FilterVatTcpLogModel;

class FilterVatTcpLogHelper
{
    public static function logDebug($client_id,$message,$type='debug'){
        self::log(null,$client_id,$message,$type);
    }

    public static function log($db,$client_id,$message,$type='common'){

        $dal = new FilterVatTcpLogDal($db);
        $model = new  FilterVatTcpLogModel();

        $model->setBody(json_encode($message));
        $model->setCreateTime(time());
        $model->setType($type);
        $model->setLevel(1);
        $model->setOwner($client_id);
        $dal->insert($model);
    }
}