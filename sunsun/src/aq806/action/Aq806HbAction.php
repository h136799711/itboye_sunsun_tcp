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
use sunsun\dal\DeviceTcpClientDal;

/**
 * Class Aq806HbAction
 * 心跳包处理
 * @package sunsun\aq806\action
 */
class Aq806HbAction
{
    public function heartBeat($did, $clientId, Aq806HbReq $req)
    {
        (new DeviceTcpClientDal())->updateByDid($did, ['update_time' => time()]);
        return new Aq806HbResp($req);
    }
}