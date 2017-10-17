<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\heating_rod\action;


use sunsun\dal\DeviceTcpClientDal;
use sunsun\heating_rod\req\HeatingRodHbReq;
use sunsun\heating_rod\resp\HeatingRodHbResp;

/**
 * Class HeatingRodHbAction
 * 心跳包处理
 * @package sunsun\heating_rod\action
 */
class HeatingRodHbAction
{
    public function heartBeat($did, $clientId, HeatingRodHbReq $req)
    {
        (new DeviceTcpClientDal())->updateByDid($did, ['update_time' => time()]);
        return new HeatingRodHbResp($req);
    }
}