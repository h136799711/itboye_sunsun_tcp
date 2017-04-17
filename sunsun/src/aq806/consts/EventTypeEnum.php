<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-04-06
 * Time: 14:07
 */

namespace sunsun\aq806\consts;


class EventTypeEnum
{
    /**
     * 无操作
     */
    const NO_ACTION = 0;
    /**
     * 冲浪水泵异常 1
     */
    const EVENT_EXCEPTION_Surf_Pump = 1;
    /**
     * 备用电源异常 2
     */
    const EVENT_EXCEPTION_Emergency_Power_Supply = 2;
    /**
     * 照明灯异常 3
     */
    const EVENT_EXCEPTION_Floodlight = 3;
    /**
     * 杀菌灯异常 4
     */
    const EVENT_EXCEPTION_Germicidal_Lamp = 4;
    /**
     * 水位过低 5
     */
    const EVENT_EXCEPTION_WaterLevel_Low = 5;
    /**
     * 水温过低 6
     */
    const EVENT_EXCEPTION_Temp_Low = 6;
    /**
     * 水温过高 7
     */
    const EVENT_EXCEPTION_Temp_High = 7;
}