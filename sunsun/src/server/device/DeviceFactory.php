<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-10
 * Time: 15:36
 */

namespace sunsun\server\device;


class DeviceFactory
{
    /**
     * 获取公共密钥 根据端口进行处理
     *
     * @param int $port
     * @return string
     */
    public static function getPublicPwd($port=8286){
        return '1234bcda';
    }
}