<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-04-06
 * Time: 14:07
 */

namespace sunsun\heating_rod\consts;


class EventTypeEnum
{
    /**
     * 无操作
     */
    const NO_ACTION = 0;
    /**
     * 实时温度
     */
    const REAL_TIME_TEMP = 1;
//0：无操作
//1：实时温度推送（服务器记录温度）
//2：加热棒过温异常
//3：温度传感器1异常
//4：温度传感器2异常
//5：加热丝开路异常
}