<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-25
 * Time: 16:15
 */

namespace sunsun\transfer_station\controller;


class ReqMsgType
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
     * 固件更新接口
     */
    const FirmwareUpdate = '104';

}