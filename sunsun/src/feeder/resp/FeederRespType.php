<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\feeder\resp;


class FeederRespType
{
    /**
     * 登录
     */
    const Login = 901;

    /**
     * 心跳包
     */
    const Heartbeat = 902;

    /**
     * 设备信息
     */
    const DeviceInfo = 903;

    /**
     * 设置请求
     */
    const Control = 904;

    /**
     * 推送请求
     */
    const Event = 905;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 906;
}