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
        return new AdtHbResp($req);
    }
}