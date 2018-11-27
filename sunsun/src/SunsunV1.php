<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
// | ©2018 California State Lottery All rights reserved.
// +----------------------------------------------------------------------
// | Author: Smith Jack
// +----------------------------------------------------------------------

namespace sunsun;

class SunsunV1
{
    const HEAD_LEN = 8;

    /**
     * 类型错误
     */
    const Err_Type = "e_type";

    /**
     * 校验失败
     */
    const Err_Sum = "e_sum";

    public static function input($recv_buffer)
    {
        $strLen = strlen($recv_buffer);
        if ($strLen < 4) {
            return 0;
        }
        $data = unpack("Nlen", $recv_buffer);
        return $data['len'];
    }

    public static function decode($recv_buffer)
    {
        $head = unpack("Nlen/ntype/nsum", $recv_buffer);
        $data = substr($recv_buffer, self::HEAD_LEN, $head['len'] - self::HEAD_LEN);
        if ($head['type'] != 1) {
            return "E_TYPE";
        }

        $sum1 = self::calSum(substr($recv_buffer, 0, 6));
        $sum = intval($sum1) + self::calSum(substr($recv_buffer, self::HEAD_LEN, $head['len'] - self::HEAD_LEN));
        $packSum = pack("n", $sum);
        $sum = unpack("n", $packSum);

        if ($sum[1] != $head['sum']) {
            return "E_SUM";
        }

        return $data;
    }

    private static function calSum($str)
    {

        $sum = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $one =  substr($str, $i, 1);
            $sum += ord($one);
        }
        return $sum;
    }

    public static function encode($encodeStr)
    {
        $totalLen = pack("N", self::HEAD_LEN + strlen($encodeStr));
        $type = pack("n", 1);
        $sum1 = self::calSum($totalLen.$type);
        $sum2 = self::calSum($encodeStr);
        $sum = $sum1 + $sum2;
        $sum = pack("n", $sum);

        return $totalLen.$type.$sum.$encodeStr;
    }
}