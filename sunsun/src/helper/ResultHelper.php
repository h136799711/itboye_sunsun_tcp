<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-20
 * Time: 16:01
 */

namespace sunsun\helper;


class ResultHelper
{
    public static function success($data, $msg = 'success')
    {
        return ['code' => 0, 'data' => $data, 'msg' => $msg];
    }

    public static function fail($msg, $data = [], $code = -1)
    {
        return ['code' => $code, 'data' => $data, 'msg' => $msg];
    }

    public static function isSuccess($result)
    {
        if (is_array($result) && $result['code'] == 0) {
            return true;
        }
        return false;
    }
}