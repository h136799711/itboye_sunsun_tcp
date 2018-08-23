<?php

class Eventst
{

    // 30秒内不能超过600次链接 否则都主动关闭链接
    static $limitTimeSeconds = 3;
    static $limitCnt = 10;
    static $reqCnt = [];

    public static function getReqCnt() {
        $now = time();
        $cnt = 0;
        for ($i = 0; $i < count(self::$reqCnt); $i++) {
            if (self::$reqCnt[$i][0] > $now - self::$limitTimeSeconds) {
                $cnt += self::$reqCnt[$i][1];
            }
        }
        return $cnt;
    }

    public static function ifOverLimitTimes()
    {

        $now = time();
        $limit = 0;
        // 大于该索引的都要去除
        $expiredTimeIndex = -1;
        for ($i = 0; $i < count(self::$reqCnt); $i++) {
            $passedTime = &self::$reqCnt[$i];
            if ($passedTime[0] <= $now - self::$limitTimeSeconds) {
                $expiredTimeIndex = $i;
            } else {
                $limit += $passedTime[1];
            }
        }
        self::$reqCnt = array_reverse(self::$reqCnt);
        while ($expiredTimeIndex-- > 0) {
            array_pop(self::$reqCnt);
        }
        self::$reqCnt = array_reverse(self::$reqCnt);

        if ($limit >= self::$limitCnt) {
            var_dump($expiredTimeIndex);
            return true;
        }


        if (count(self::$reqCnt) > 0 && self::$reqCnt[count(self::$reqCnt) - 1][0] == $now) {
            self::$reqCnt[count(self::$reqCnt) - 1][1]++;
        } else {
            array_push(self::$reqCnt, [$now, 1]);
        }

        return false;
    }
}

for ($req = 0; $req < 33; $req++) {
    if (Eventst::ifOverLimitTimes()) {
        echo $req . " 请求过载", "\n";
    } else {
        echo $req . " success", "\n";
    }
    if ($req % 11 == 0) {
        sleep(3);
    }
    echo Eventst::$limitTimeSeconds."秒内,累计请求次数: ",Eventst::getReqCnt(),"\n";
}