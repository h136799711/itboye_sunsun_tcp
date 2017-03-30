<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\filter_vat\resp;


class FilterVatRespType
{
    /**
     * 登录
     */
    const Login = 1;

    /**
     * 心跳包
     */
    const Heartbeat = 2;

    /**
     * 设备信息
     */
    const DeviceInfo = 3;

    /**
     * 设置请求
     */
    const Control = 4;

    /**
     * 推送请求
     */
    const Event = 5;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 6;

    /**
     *
     */
    const Logout = 999;
}