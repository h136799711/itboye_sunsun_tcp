<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\heating_rod\action;

use sunsun\heating_rod\consts\HeatingEventEnum;
use sunsun\server\business\ProxyEvents;
use sunsun\server\interfaces\BaseAction;
use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * Class HeatingRodHbAction
 * 心跳包处理
 * @package sunsun\heating_rod\action
 */
class HeatingRodHbAction extends BaseAction
{
    public function deviceHeartBeat($did, $clientId, BaseHeartBeatClientReq $req)
    {
        $respObj = parent::deviceHeartBeat($did, $clientId, $req);
        ProxyEvents::publish(HeatingEventEnum::Hb, json_encode(['did'=>$did, 'time'=>time()]));
        return $respObj;
    }
}