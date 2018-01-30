<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\aq118\resp;


class Aq118RespType
{
    /**
     * 登录
     */
    const Login = 701;

    /**
     * 心跳包
     */
    const Heartbeat = 702;

    /**
     * 设备信息
     */
    const DeviceInfo = 703;

    /**
     * 设置请求
     */
    const Control = 704;

    /**
     * 推送请求
     */
    const Event = 705;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 706;

    /**
     *
     */
    const Logout = 999;
}