<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\adt\action;


use sunsun\adt\req\AdtHbReq;
use sunsun\adt\resp\AdtHbResp;

/**
 * Class AdtHbAction
 * 心跳包处理
 * @package sunsun\adt\action
 */
class AdtHbAction
{
    public function heartBeat($clientId, AdtHbReq $req)
    {
        return new AdtHbResp($req);
    }
}