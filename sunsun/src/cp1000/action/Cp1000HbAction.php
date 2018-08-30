<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;


use sunsun\server\business\ProxyEvents;
use sunsun\server\interfaces\BaseAction;
use sunsun\server\req\BaseHeartBeatClientReq;

/**
 * Class Cp1000HbAction
 * 心跳包处理
 * @package sunsun\cp1000\action
 */
class Cp1000HbAction extends BaseAction
{
    public function deviceHeartBeat($did, $clientId, BaseHeartBeatClientReq $req)
    {
        $respObj = parent::deviceHeartBeat($did, $clientId, $req);
        ProxyEvents::publish(['type'=>'hb', 'did'=>$did, 'time'=>time()]);
        return $respObj;
    }
}