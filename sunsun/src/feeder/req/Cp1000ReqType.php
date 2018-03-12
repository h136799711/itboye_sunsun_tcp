<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\feeder\req;


class FeederReqType
{
    /**
     * 登录
     */
    const Login = 601;

    /**
     * 心跳包
     */
    const Heartbeat = 602;

    /**
     * 设备信息
     */
    const DeviceInfo = 603;

    /**
     * 设置请求
     */
    const Control = 604;

    /**
     * 推送请求
     */
    const Event = 605;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 606;
}