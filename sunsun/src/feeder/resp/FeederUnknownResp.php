<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\resp;


use sunsun\po\BaseRespPo;

class FeederUnknownResp extends BaseRespPo
{

    public function __construct()
    {
        parent::__construct(null);
    }


    /**
     * 转换为数据数组
     * @return array
     */
    function toDataArray()
    {
        return [
        ];
    }


}