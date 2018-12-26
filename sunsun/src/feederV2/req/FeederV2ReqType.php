<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\feederV2\req;


class FeederV2ReqType
{
    /**
     * 登录
     */
    const Login = 1101;

    /**
     * 心跳包
     */
    const Heartbeat = 1102;

    /**
     * 设备信息
     */
    const DeviceInfo = 1103;

    /**
     * 设置请求
     */
    const Control = 1104;

    /**
     * 推送请求
     */
    const Event = 1105;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 1106;
}