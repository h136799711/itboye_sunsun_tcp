<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\cp1000\action;

use sunsun\cp1000\req\Cp1000LoginReq;
use sunsun\server\interfaces\BaseAction;

class Cp1000LoginAction extends BaseAction
{
    public function login($did, $clientId, Cp1000LoginReq $req)
    {
        return $this->deviceLogin($did, $clientId, $req);
    }

}