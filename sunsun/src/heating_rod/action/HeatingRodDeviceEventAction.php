<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 22:11
 */

namespace sunsun\heating_rod\action;


use GatewayWorker\Lib\Gateway;
use sunsun\heating_rod\consts\EventTypeEnum;
use sunsun\heating_rod\dal\HeatingRodDeviceEventDal;
use sunsun\heating_rod\dal\HeatingRodTempHisDal;
use sunsun\heating_rod\model\HeatingRodDeviceEventModel;
use sunsun\heating_rod\model\HeatingRodDeviceModel;
use sunsun\heating_rod\model\HeatingRodTempHisModel;
use sunsun\heating_rod\req\HeatingRodDeviceEventReq;
use sunsun\heating_rod\resp\HeatingRodDeviceEventResp;

/**
 * Class HeatingRodDeviceEventAction
 * 设备事件记录
 * @package sunsun\heating_rod\action
 */
class HeatingRodDeviceEventAction
{
    public function logEvent($did,$client_id,HeatingRodDeviceEventReq $req){
        $eventType = $req->getCode();
        $eventInfo = json_encode(['code_desc'=>$req->getCodeDesc(),'t'=>$req->getT()]);
        $now = time();
        $dal = (new HeatingRodDeviceEventDal());
        $do  = new HeatingRodDeviceEventModel();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($eventInfo);
        $do->setEventType($eventType);
        $result = $dal->insert($do);

        $resp = new HeatingRodDeviceEventResp($req);
        $resp->setState(0);

        //
        if($eventType == EventTypeEnum::REAL_TIME_TEMP){
            //实时温度记录

            $dal = (new HeatingRodTempHisDal());
            $model  = new HeatingRodTempHisModel();
            $model->setDid($did);
            $model->setCreateTime($now);
            $model->setTemp($req->getT());
            $dal->insert($model);
        }

        return $resp;
    }

}