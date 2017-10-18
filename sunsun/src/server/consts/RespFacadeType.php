<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 14:27
 */

namespace sunsun\server\consts;


use sunsun\adt\resp\AdtRespType;
use sunsun\aph300\resp\Aph300RespType;
use sunsun\aq806\resp\Aq806RespType;
use sunsun\cp1000\resp\Cp1000RespType;
use sunsun\filter_vat\resp\FilterVatRespType;
use sunsun\heating_rod\resp\HeatingRodRespType;
use sunsun\water_pump\resp\WaterPumpRespType;

class RespFacadeType
{
    const LOGIN = 'login';
    const HEART_BEAT = 'heart_beat';
    const DEVICE_INFO = 'device_info';
    const FIRMWARE_UPDATE = 'firmware_update';
    const CONTROL = 'control';
    const EVENT = 'event';
    private static $facade = null;

    public function __construct()
    {
        $this->init();
    }

    public static function getInstance()
    {
        if (self::$facade == null) {
            self::$facade = new RespFacadeType();
        }
        return self::$facade;
    }

    public function getDeviceArray()
    {
        return $this->deviceArr;
    }

    private $deviceArr = [];

    public static function getRespType($did, $facadeRespTypeKey)
    {
        $deviceType = DeviceType::getDeviceType($did);
        $deviceArr = RespFacadeType::getInstance()->getDeviceArray();
        $deviceRespType = $deviceArr[$deviceType];
        return $deviceRespType[$facadeRespTypeKey];
    }

    public function init()
    {
        // 过滤桶 S01
        self::$deviceArr[DeviceType::Did_FilterVat] = [];
        self::$deviceArr[DeviceType::Did_FilterVat][self::LOGIN] = FilterVatRespType::Login;
        self::$deviceArr[DeviceType::Did_FilterVat][self::HEART_BEAT] = FilterVatRespType::Heartbeat;
        self::$deviceArr[DeviceType::Did_FilterVat][self::DEVICE_INFO] = FilterVatRespType::DeviceInfo;
        self::$deviceArr[DeviceType::Did_FilterVat][self::FIRMWARE_UPDATE] = FilterVatRespType::FirmwareUpdate;
        self::$deviceArr[DeviceType::Did_FilterVat][self::CONTROL] = FilterVatRespType::Control;
        self::$deviceArr[DeviceType::Did_FilterVat][self::EVENT] = FilterVatRespType::Event;
        // 加热棒 S02
        self::$deviceArr[DeviceType::Did_HeatingRod] = [];
        self::$deviceArr[DeviceType::Did_HeatingRod][self::LOGIN] = HeatingRodRespType::Login;
        self::$deviceArr[DeviceType::Did_HeatingRod][self::HEART_BEAT] = HeatingRodRespType::Heartbeat;
        self::$deviceArr[DeviceType::Did_HeatingRod][self::DEVICE_INFO] = HeatingRodRespType::DeviceInfo;
        self::$deviceArr[DeviceType::Did_HeatingRod][self::FIRMWARE_UPDATE] = HeatingRodRespType::FirmwareUpdate;
        self::$deviceArr[DeviceType::Did_HeatingRod][self::CONTROL] = HeatingRodRespType::Control;
        self::$deviceArr[DeviceType::Did_HeatingRod][self::EVENT] = HeatingRodRespType::Event;
        // aq806 S03
        self::$deviceArr[DeviceType::Did_AQ806] = [];
        self::$deviceArr[DeviceType::Did_AQ806][self::LOGIN] = Aq806RespType::Login;
        self::$deviceArr[DeviceType::Did_AQ806][self::HEART_BEAT] = Aq806RespType::Heartbeat;
        self::$deviceArr[DeviceType::Did_AQ806][self::DEVICE_INFO] = Aq806RespType::DeviceInfo;
        self::$deviceArr[DeviceType::Did_AQ806][self::FIRMWARE_UPDATE] = Aq806RespType::FirmwareUpdate;
        self::$deviceArr[DeviceType::Did_AQ806][self::CONTROL] = Aq806RespType::Control;
        self::$deviceArr[DeviceType::Did_AQ806][self::EVENT] = Aq806RespType::Event;
        // aph300 S04
        self::$deviceArr[DeviceType::Did_APH300] = [];
        self::$deviceArr[DeviceType::Did_APH300][self::LOGIN] = Aph300RespType::Login;
        self::$deviceArr[DeviceType::Did_APH300][self::HEART_BEAT] = Aph300RespType::Heartbeat;
        self::$deviceArr[DeviceType::Did_APH300][self::DEVICE_INFO] = Aph300RespType::DeviceInfo;
        self::$deviceArr[DeviceType::Did_APH300][self::FIRMWARE_UPDATE] = Aph300RespType::FirmwareUpdate;
        self::$deviceArr[DeviceType::Did_APH300][self::CONTROL] = Aph300RespType::Control;
        self::$deviceArr[DeviceType::Did_APH300][self::EVENT] = Aph300RespType::Event;
        // 变频水泵 S05
        self::$deviceArr[DeviceType::Did_WaterPump] = [];
        self::$deviceArr[DeviceType::Did_WaterPump][self::LOGIN] = WaterPumpRespType::Login;
        self::$deviceArr[DeviceType::Did_WaterPump][self::HEART_BEAT] = WaterPumpRespType::Heartbeat;
        self::$deviceArr[DeviceType::Did_WaterPump][self::DEVICE_INFO] = WaterPumpRespType::DeviceInfo;
        self::$deviceArr[DeviceType::Did_WaterPump][self::FIRMWARE_UPDATE] = WaterPumpRespType::FirmwareUpdate;
        self::$deviceArr[DeviceType::Did_WaterPump][self::CONTROL] = WaterPumpRespType::Control;
        self::$deviceArr[DeviceType::Did_WaterPump][self::EVENT] = WaterPumpRespType::Event;
        // ADT S06
        self::$deviceArr[DeviceType::Did_ADT] = [];
        self::$deviceArr[DeviceType::Did_ADT][self::LOGIN] = AdtRespType::Login;
        self::$deviceArr[DeviceType::Did_ADT][self::HEART_BEAT] = AdtRespType::Heartbeat;
        self::$deviceArr[DeviceType::Did_ADT][self::DEVICE_INFO] = AdtRespType::DeviceInfo;
        self::$deviceArr[DeviceType::Did_ADT][self::FIRMWARE_UPDATE] = AdtRespType::FirmwareUpdate;
        self::$deviceArr[DeviceType::Did_ADT][self::CONTROL] = AdtRespType::Control;
        self::$deviceArr[DeviceType::Did_ADT][self::EVENT] = AdtRespType::Event;

        // Cp1000 S07
        self::$deviceArr[DeviceType::Did_CP1000] = [];
        self::$deviceArr[DeviceType::Did_CP1000][self::LOGIN] = Cp1000RespType::Login;
        self::$deviceArr[DeviceType::Did_CP1000][self::HEART_BEAT] = Cp1000RespType::Heartbeat;
        self::$deviceArr[DeviceType::Did_CP1000][self::DEVICE_INFO] = Cp1000RespType::DeviceInfo;
        self::$deviceArr[DeviceType::Did_CP1000][self::FIRMWARE_UPDATE] = Cp1000RespType::FirmwareUpdate;
        self::$deviceArr[DeviceType::Did_CP1000][self::CONTROL] = Cp1000RespType::Control;
        self::$deviceArr[DeviceType::Did_CP1000][self::EVENT] = Cp1000RespType::Event;

    }
}