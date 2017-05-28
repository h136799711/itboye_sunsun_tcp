<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\filter_vat\action;


use sunsun\filter_vat\dal\FilterVatDeviceEventDal;
use sunsun\filter_vat\model\FilterVatDeviceEventModel;
use sunsun\filter_vat\req\FilterVatDeviceEventReq;
use sunsun\filter_vat\resp\FilterVatDeviceEventResp;

/**
 * Class FilterVatDeviceEventAction
 * 设备事件记录
 * @package sunsun\filter_vat\action
 */
class FilterVatDeviceEventAction
{
    public function logEvent($did, $client_id, FilterVatDeviceEventReq $req)
    {
        $eventType = $req->getCode();
        $eventInfo = json_encode([]);
        $now = time();
        $dal = (new FilterVatDeviceEventDal());
        $do = new FilterVatDeviceEventModel();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $result = $dal->insert($do);

        $resp = new FilterVatDeviceEventResp($req);
        $resp->setState(0);
        return $resp;
    }

}