<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-16
 * Time: 11:30
 */

namespace sunsun\server\interfaces;

use GatewayWorker\Lib\Gateway;
use sunsun\dal\DeviceTcpClientDal;
use sunsun\decoder\SunsunTDS;
use sunsun\helper\DevToServerDelayHelper;
use sunsun\helper\ResultHelper;
use sunsun\po\BaseRespPo;
use sunsun\server\consts\SunsunDeviceConstant;
use sunsun\server\db\DbPool;
use sunsun\server\factory\DeviceFacadeFactory;
use sunsun\server\factory\RespFacadeFactory;
use sunsun\server\model\BaseDeviceEventModel;
use sunsun\server\req\BaseDeviceEventClientReq;
use sunsun\server\req\BaseDeviceLoginClientReq;
use sunsun\server\req\BaseHeartBeatClientReq;
use sunsun\server\resp\BaseControlDeviceClientResp;
use sunsun\server\resp\BaseDeviceFirmwareUpdateClientResp;
use sunsun\transfer_station\client\TransferClient;
use sunsun\transfer_station\controller\RespMsgType;

/**
 * 通用设备处理类
 * Class BaseAction
 * @package sunsun\server\interfaces
 */
abstract class BaseAction
{

    /**
     * 心跳计数最大 - 例如等于2 则每2次心跳才更新一次数据库
     * 0 < 心跳次数  < 720 / 心跳间隔时间（默认是120） 这个是离线检测的时间
     * 查看
     * itboye_sunsunxiaoli项目的
     * app\index\helper\CommandHelper::offline_notify 中的定义
     */
    const HB_COUNT_MAX = 2;

    /**
     * 最近插入数据库的缓存数据
     */
    const CACHE_COUNT_MAX = 3;

    /**
     * 通用设备信息更新
     * @param string $did
     * @param string $clientId
     * @param BaseRespPo $resp
     * @param BaseDalV2 $dal
     * @return array
     * @throws \Exception
     */
    public function deviceInfoUpdate($did, $clientId, BaseRespPo $resp, BaseDalV2 $dal)
    {
        if (!method_exists($resp, 'toDbEntityArray')) {
            throw new \Exception('resp toDbEntityArray method missing');
        }
        // 更新设备信息
        $updateEntity = $resp->toDbEntityArray();
        $avg = DevToServerDelayHelper::logRespTime($clientId, $resp);
        if ($avg > 12345679.999) {
            $avg = 12345679.999;
        }
        if ($avg > 0) {
            $updateEntity['delay_avg'] = $avg;
        }
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn());
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

    /**
     * 通用设备心跳请求
     * @param $did
     * @param $clientId
     * @param BaseHeartBeatClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\aph300\resp\Aph300CtrlDeviceResp|\sunsun\aph300\resp\Aph300DeviceInfoResp|\sunsun\aph300\resp\Aph300DeviceUpdateResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\cp1000\resp\Cp1000CtrlDeviceResp|\sunsun\cp1000\resp\Cp1000DeviceFirmwareUpdateResp|\sunsun\cp1000\resp\Cp1000DeviceInfoResp|\sunsun\cp1000\resp\Cp1000HbResp|\sunsun\heating_rod\resp\HeatingRodCtrlDeviceResp|\sunsun\heating_rod\resp\HeatingRodDeviceInfoResp|\sunsun\heating_rod\resp\HeatingRodDeviceUpdateResp
     */
    public function deviceHeartBeat($did, $clientId, BaseHeartBeatClientReq $req)
    {
        $session = Gateway::getSession($clientId);
        $hbCnt = 1;

        if ($session && array_key_exists('hb_cnt', $session)) {
            $hbCnt = intval($session['hb_cnt']);
            if ($hbCnt < self::HB_COUNT_MAX) {
                $hbCnt++;
            } else {
                $hbCnt = 1;
                (DeviceFacadeFactory::getDeviceDal($did))->updateByDid($did, ['update_time' => time()]);
            }
        }

        Gateway::updateSession($clientId, ['hb_cnt' => $hbCnt]);

        $respObj = RespFacadeFactory::createHeartBeatRespObj($did, $req);
        return $respObj;
    }

    /**
     * 设备控制设备信息返回更新
     * @param $did
     * @param $clientId
     * @param BaseRespPo|BaseControlDeviceClientResp $resp
     * @param BaseDalV2 $dal
     * @return array
     * @throws \Exception
     */
    public function deviceControlInfoUpdate($did, $clientId, BaseControlDeviceClientResp $resp, BaseDalV2 $dal)
    {
        if (!method_exists($resp, 'toDbEntityArray')) {
            throw new \Exception('resp toDbEntityArray method missing');
        }
        //更新设备信息
        $updateEntity = $resp->toDbEntityArray();
        $avg = DevToServerDelayHelper::logRespTime($clientId, $resp);
        if ($avg > 12345679.999) {
            $avg = 12345679.999;
        }
        if ($avg > 0) {
            $updateEntity['delay_avg'] = $avg;
        }
        // 向中转通道发送信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn(), RespMsgType::DeviceControl);
        $updateEntity['update_time'] = time();
        if (method_exists($dal, 'updateByDid')) {
            $ret = $dal->updateByDid($did, $updateEntity);
            return ResultHelper::success($ret);
        } else {
            return ResultHelper::fail('updateByDid method missing');
        }
    }

    /**
     * 通用设备固件更新
     * @param $did
     * @param $clientId
     * @param BaseDeviceFirmwareUpdateClientResp $resp
     * @return array
     */
    public function firmUpdate($did, $clientId, BaseDeviceFirmwareUpdateClientResp $resp)
    {
        $dal = DeviceFacadeFactory::getDeviceDal($did);
        // 更新设备信息
        $updateEntity = [
            'device_state' => $resp->getState(),
            'update_time' => time()
        ];
        // 向中转通道发送设备更新信息
        TransferClient::sendMessageToGroup($did, $updateEntity, $resp->getSn(), RespMsgType::FirmwareUpdate);
        $ret = $dal->updateByDid($did, $updateEntity);
        return ResultHelper::success($ret);
    }

    /**
     * 通用设备登录
     * @param $did
     * @param $clientId
     * @param BaseDeviceLoginClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\adt\resp\AdtHbResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\aq806\resp\Aq806HbResp|\sunsun\filter_vat\resp\FilterVatCtrlDeviceResp|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|\sunsun\filter_vat\resp\FilterVatDeviceInfoResp|\sunsun\filter_vat\resp\FilterVatDeviceUpdateResp|\sunsun\filter_vat\resp\FilterVatHbResp|\sunsun\filter_vat\resp\FilterVatLoginResp|\sunsun\water_pump\resp\WaterPumpCtrlDeviceResp|\sunsun\water_pump\resp\WaterPumpDeviceInfoResp|\sunsun\water_pump\resp\WaterPumpDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpHbResp
     */
    public function deviceLogin($did, $clientId, BaseDeviceLoginClientReq $req)
    {
        $resp = RespFacadeFactory::createLoginRespObj($did, $req);
        $dal = DeviceFacadeFactory::getDeviceDal($did);

        $resp->setSn($req->getSn());
        $resp->setHb(SunsunDeviceConstant::DEFAULT_HEART_BEAT);
        $result = $dal->getInfoByDid($did);
        if (empty($result)) {
            $resp->setLoginFail();
            return $resp;
        }
        $pwd = $result['pwd'];
        $hb = $result['hb'];
        $resp->setServerInfo($result);
        $resp->setHb($hb);
        //更新设备信息
        $encryptPwd = $req->getPwd();

        $originPwd = SunsunTDS::isLegalPwd($encryptPwd, $pwd);
        if (empty($originPwd)) {
            $resp->setLoginFail();
            return $resp;
        }

        //更新控制密码
        $time = time();
        $ver = $req->getVer();
        $entity = [
            'ver' => $ver,
            'offline_notify' => 1,
            'ctrl_pwd' => $originPwd,
            'last_login_time' => $time,
            'update_time' => $time,
        ];

        $ret = $dal->updateByDid($did, $entity);
        // 更新时间
        $tcpClientDal = new DeviceTcpClientDal(DbPool::getInstance()->getGlobalDb());

        $tcpClientDal->updateByDid($did, ['tcp_client_id' => $clientId, 'prev_login_time' => $time]);

        $dal = new DeviceTcpClientDal(DbPool::getInstance()->getGlobalDb());
        $dal->updateByDid($did, ['prev_login_time' => $time]);

        $resp->setLoginSuccess();

        return $resp;

    }


    /**
     * 通用设备推送事件记录
     * @param $did
     * @param $client_id
     * @param BaseDeviceEventClientReq $req
     * @return null|\sunsun\adt\resp\AdtCtrlDeviceResp|\sunsun\adt\resp\AdtDeviceInfoResp|\sunsun\adt\resp\AdtDeviceUpdateResp|\sunsun\adt\resp\AdtHbResp|\sunsun\aq806\resp\Aq806CtrlDeviceResp|\sunsun\aq806\resp\Aq806DeviceInfoResp|\sunsun\aq806\resp\Aq806DeviceUpdateResp|\sunsun\aq806\resp\Aq806HbResp|\sunsun\filter_vat\resp\FilterVatCtrlDeviceResp|\sunsun\filter_vat\resp\FilterVatDeviceEventResp|\sunsun\filter_vat\resp\FilterVatDeviceInfoResp|\sunsun\filter_vat\resp\FilterVatDeviceUpdateResp|\sunsun\filter_vat\resp\FilterVatHbResp|\sunsun\filter_vat\resp\FilterVatLoginResp|\sunsun\water_pump\resp\WaterPumpCtrlDeviceResp|\sunsun\water_pump\resp\WaterPumpDeviceInfoResp|\sunsun\water_pump\resp\WaterPumpDeviceUpdateResp|\sunsun\water_pump\resp\WaterPumpHbResp
     */
    public function deviceEventLog($did, $client_id, BaseDeviceEventClientReq $req)
    {
        // 测试设备
        $this->delayInsertDeviceEvent($did, $client_id, $req);
        $resp = RespFacadeFactory::createDeviceEventRespObj($did, $req);
        $resp->setState(0);
        return $resp;
    }

    /**
     * 最近几个相同的数据只会插一次
     * @param $did
     * @param $client_id
     * @param $req
     */
    private function delayInsertDeviceEvent($did, $client_id, BaseDeviceEventClientReq $req)
    {

        $session = Gateway::getSession($client_id);

        if (array_key_exists('event', $session)) {
            $event = $session['event'];
        } else {
            $event = [];
        }

        $eventType = $req->getCode();
        $eventInfo = json_encode($req->getEventInfo());
        $now = time();
        $data = [
            'did' => $did,
            "event_type" => $eventType,
            "event_info" => $eventInfo,
            "create_time" => $now
        ];

        // 判断是否 可以插入数据
        $flag = true;
        foreach ($event as $row) {
            if ($row['event_type'] == $eventType
                && $row['event_info'] == $eventInfo
                && $now - intval($row['create_time']) < 600) {
                $flag = false;
                break;
            }
        }

        if (count($event) == 0 || $flag) {

            // event_type 不相等
            // event_info 不相等
            // 时间超过 600秒以上
            // 以上任一条件满足
            $this->insertDeviceEvent($data, $did);
            // 保持个数限制
            if (count($event) >= self::CACHE_COUNT_MAX) {
                // 从开头移走一个
                array_shift($event);
            }

            array_push($event, $data);

            Gateway::updateSession($client_id, ['event' => $event]);
        }
    }

    private function insertDeviceEvent($data, $did)
    {
        $dal = DeviceFacadeFactory::getDeviceEventDal($did);
        $do = new BaseDeviceEventModel();
        $now = time();
        $do->setDid($did);
        $do->setCreateTime($now);
        $do->setUpdateTime($now);
        $do->setEventInfo($data['event_info']);
        $do->setEventType($data['event_type']);
        $dal->insert($do);
    }

}