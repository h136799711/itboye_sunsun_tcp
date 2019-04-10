<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\aq136\resp;


class Aq136RespType
{
    /**
     * 登录
     */
    const Login = 1301;

    /**
     * 心跳包
     */
    const Heartbeat = 1302;

    /**
     * 设备信息
     */
    const DeviceInfo = 1303;

    /**
     * 设置请求
     */
    const Control = 1304;

    /**
     * 推送请求
     */
    const Event = 1305;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 1306;

    /**
     *
     */
    const Logout = 999;
}