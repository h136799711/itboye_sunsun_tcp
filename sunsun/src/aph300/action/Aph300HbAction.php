<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\aph300\action;


use sunsun\aph300\req\Aph300HbReq;
use sunsun\aph300\resp\Aph300HbResp;

/**
 * Class Aph300HbAction
 * 心跳包处理
 * @package sunsun\aph300\action
 */
class Aph300HbAction
{
    public function heartBeat($did, $clientId, Aph300HbReq $req)
    {
        // 更新用户时间
//        (new Aph300DeviceDal())->updateByDid($did,['update_time'=>time()]);
        return new Aph300HbResp($req);
    }
}