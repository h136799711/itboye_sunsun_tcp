<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;


use sunsun\cp1000\req\Cp1000HbReq;
use sunsun\cp1000\resp\Cp1000HbResp;
use sunsun\server\interfaces\BaseAction;

/**
 * Class Cp1000HbAction
 * 心跳包处理
 * @package sunsun\cp1000\action
 */
class Cp1000HbAction extends BaseAction
{
    public function heartBeat($did, $clientId, Cp1000HbReq $req)
    {
        return new Cp1000HbResp($req);
    }
}