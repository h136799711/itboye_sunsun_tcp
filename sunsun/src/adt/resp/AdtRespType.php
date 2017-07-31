<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\adt\resp;


class AdtRespType
{
    /**
     * 登录
     */
    const Login = 501;

    /**
     * 心跳包
     */
    const Heartbeat = 502;

    /**
     * 设备信息
     */
    const DeviceInfo = 503;

    /**
     * 设置请求
     */
    const Control = 504;

    /**
     * 推送请求
     */
    const Event = 505;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 506;

    /**
     *
     */
    const Logout = 999;
}