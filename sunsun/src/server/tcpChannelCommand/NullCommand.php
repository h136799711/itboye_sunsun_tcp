<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 14:52
 */

namespace sunsun\server\tcpChannelCommand;


class NullCommand implements TcpChannelCommandInterface
{
    function acceptParams($params)
    {
    }


    function execute()
    {
        // do nothing
    }
}