<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\hwfish\resp;


class HwfishRespType
{
    /**
     * 登录
     */
    const Login = 1201;

    /**
     * 心跳包
     */
    const Heartbeat = 1202;

    /**
     * 设备信息
     */
    const DeviceInfo = 1203;

    /**
     * 设置请求
     */
    const Control = 1204;

    /**
     * 推送请求
     */
    const Event = 1205;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 1206;

    /**
     *
     */
    const Logout = 999;
}