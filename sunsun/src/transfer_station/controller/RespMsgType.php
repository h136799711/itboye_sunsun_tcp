<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-25
 * Time: 17:51
 */

namespace sunsun\transfer_station\controller;


class RespMsgType
{

    /**
     * 心跳
     */
    const Hb = '100';

    /**
     * 登录
     */
    const Login = '101';

    /**
     * 获取信息
     */
    const Info = '102';

    /**
     * 切换分组
     */
    const SwitchGroup = '103';

    /**
     * 设备更新信息
     */
    const FirmwareUpdate = '104';

    /**
     * 设备控制信息
     */
    const DeviceControl = '105';

}