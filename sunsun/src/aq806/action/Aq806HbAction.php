<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aq806\action;


use sunsun\aq806\req\Aq806HbReq;
use sunsun\aq806\resp\Aq806HbResp;

/**
 * Class Aq806HbAction
 * 心跳包处理
 * @package sunsun\aq806\action
 */
class Aq806HbAction
{
    public function heartBeat($clientId,Aq806HbReq $req)
    {
        return new Aq806HbResp($req);
    }
}