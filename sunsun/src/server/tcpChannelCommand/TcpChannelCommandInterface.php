<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 14:44
 */

namespace sunsun\server\tcpChannelCommand;


interface TcpChannelCommandInterface
{
    function acceptParams($params);
    function execute();
}