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
use sunsun\server\consts\RespFacadeType;
use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\interfaces\BaseAction;

/**
 * Class AdtHbAction
 * 心跳包处理
 * @package sunsun\adt\action
 */
class AdtHbAction extends BaseAction
{
    public function heartBeat($did, $clientId, AdtHbReq $req)
    {
        RespFacadeFactory::createRespObj($did, RespFacadeType::HEART_BEAT, $req->toDataArray());
        return new AdtHbResp($req);
    }
}