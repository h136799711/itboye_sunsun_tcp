<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 17:56
 */

namespace sunsun\pet_feeder\req;


class PetFeederReqType
{
    /**
     * 登录
     */
    const Login = 1001;

    /**
     * 心跳包
     */
    const Heartbeat = 1002;

    /**
     * 设备信息
     */
    const DeviceInfo = 1003;

    /**
     * 设置请求
     */
    const Control = 1004;

    /**
     * 推送请求
     */
    const Event = 1005;

    /**
     *  固件更新
     */
    const FirmwareUpdate = 1006;
}