<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\heating_rod\resp;


class HeatingRodRespType
{
    /**
     * 登录
     */
    const Login = 101;

    /**
     * 心跳包
     */
    const Heartbeat = 102;

    /**
     * 设备信息
     */
    const DeviceInfo = 103;

    /**
     * 设置请求
     */
    const Control = 104;

    /**
     * 推送请求
     */
    const Event = 105;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 106;

    /**
     *
     */
    const Logout = 999;
}