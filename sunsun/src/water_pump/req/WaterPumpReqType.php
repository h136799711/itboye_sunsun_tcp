<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\water_pump\req;


class WaterPumpReqType
{
    /**
     * 登录
     */
    const Login = 201;

    /**
     * 心跳包
     */
    const Heartbeat = 202;

    /**
     * 设备信息
     */
    const DeviceInfo = 203;

    /**
     * 设置请求
     */
    const Control = 204;

    /**
     * 推送请求
     */
    const Event = 205;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 206;
}