<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\aq806\resp;


class Aq806RespType
{
    /**
     * 登录
     */
    const Login = 301;

    /**
     * 心跳包
     */
    const Heartbeat = 302;

    /**
     * 设备信息
     */
    const DeviceInfo = 303;

    /**
     * 设置请求
     */
    const Control = 304;

    /**
     * 推送请求
     */
    const Event = 305;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 306;

    /**
     *
     */
    const Logout = 999;
}