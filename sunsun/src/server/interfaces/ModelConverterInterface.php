<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-18
 * Time: 10:38
 */

namespace sunsun\server\interfaces;

use sunsun\po\BaseRespPo;

interface ModelConverterInterface
{
    static function convertToModelArray(BaseRespPo $resp);

    static function convertToModelArrayOfCtrlDeviceResp(BaseRespPo $resp);
}