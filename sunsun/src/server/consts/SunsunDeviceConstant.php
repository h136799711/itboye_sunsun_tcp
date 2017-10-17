<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 11:46
 */

namespace sunsun\server\consts;

/**
 * Class SunsunDeviceConstant
 * 可能会更改的常量记录在此
 * @package sunsun\server\consts
 */
class SunsunDeviceConstant
{
    /**
     * 设备默认心跳请求间隔 单位 秒
     */
    const DEFAULT_HEART_BEAT = 120;

    /**
     * 设备与服务器超过时间没有进行通信下，则作为离线的判断条件 单位 秒
     * 目前取值心跳时间的3倍
     */
    const DEVICE_OFFLINE_TIME_INTERVAL = 3 * self::DEFAULT_HEART_BEAT;

    /**
     * 每x秒检测tcp通道是否离线 单位 秒
     */
    const CHECK_OFFLINE_SESSION_INTERVAL = 6;
}