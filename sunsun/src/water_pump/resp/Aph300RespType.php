<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\water_pump\resp;


class WaterPumpRespType
{
    /**
     * 登录
     */
    const Login = 401;

    /**
     * 心跳包
     */
    const Heartbeat = 402;

    /**
     * 设备信息
     */
    const DeviceInfo = 403;

    /**
     * 设置请求
     */
    const Control = 404;

    /**
     * 推送请求
     */
    const Event = 405;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 406;
}