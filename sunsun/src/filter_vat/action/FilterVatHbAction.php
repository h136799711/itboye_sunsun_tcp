<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\filter_vat\action;


use sunsun\dal\DeviceTcpClientDal;
use sunsun\filter_vat\req\FilterVatHbReq;
use sunsun\filter_vat\resp\FilterVatHbResp;

/**
 * Class FilterVatHbAction
 * 心跳包处理
 * @package sunsun\filter_vat\action
 */
class FilterVatHbAction
{
    public function heartBeat($did, $clientId, FilterVatHbReq $req)
    {
        (new DeviceTcpClientDal())->updateByDid($did, ['update_time' => time()]);
        return new FilterVatHbResp($req);
    }
}