<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 14:44
 */

namespace sunsun\server\tcpChannelCommand;


use sunsun\server\consts\CommandTypes;

class CommandFactory
{
    public static function create($type){
        if ($type == CommandTypes::CLOSE_CLIENT){
            return new CloseCommand();
        }
        return new NullCommand();
    }
}