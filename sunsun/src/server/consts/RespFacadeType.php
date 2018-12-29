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
use sunsun\aq118\resp\Aq118RespType;
use sunsun\aq806\resp\Aq806RespType;
use sunsun\cp1000\resp\Cp1000RespType;
use sunsun\feeder\resp\FeederRespType;
use sunsun\filter_vat\resp\FilterVatRespType;
use sunsun\heating_rod\resp\HeatingRodRespType;
use sunsun\pet_feeder\resp\PetFeederRespType;
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
        $this->deviceArr[DeviceType::Did_FilterVat] = [];
        $this->deviceArr[DeviceType::Did_FilterVat][self::LOGIN] = FilterVatRespType::Login;
        $this->deviceArr[DeviceType::Did_FilterVat][self::HEART_BEAT] = FilterVatRespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_FilterVat][self::DEVICE_INFO] = FilterVatRespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_FilterVat][self::FIRMWARE_UPDATE] = FilterVatRespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_FilterVat][self::CONTROL] = FilterVatRespType::Control;
        $this->deviceArr[DeviceType::Did_FilterVat][self::EVENT] = FilterVatRespType::Event;
        // 加热棒 S02
        $this->deviceArr[DeviceType::Did_HeatingRod] = [];
        $this->deviceArr[DeviceType::Did_HeatingRod][self::LOGIN] = HeatingRodRespType::Login;
        $this->deviceArr[DeviceType::Did_HeatingRod][self::HEART_BEAT] = HeatingRodRespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_HeatingRod][self::DEVICE_INFO] = HeatingRodRespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_HeatingRod][self::FIRMWARE_UPDATE] = HeatingRodRespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_HeatingRod][self::CONTROL] = HeatingRodRespType::Control;
        $this->deviceArr[DeviceType::Did_HeatingRod][self::EVENT] = HeatingRodRespType::Event;
        // aq806 S03
        $this->deviceArr[DeviceType::Did_AQ806] = [];
        $this->deviceArr[DeviceType::Did_AQ806][self::LOGIN] = Aq806RespType::Login;
        $this->deviceArr[DeviceType::Did_AQ806][self::HEART_BEAT] = Aq806RespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_AQ806][self::DEVICE_INFO] = Aq806RespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_AQ806][self::FIRMWARE_UPDATE] = Aq806RespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_AQ806][self::CONTROL] = Aq806RespType::Control;
        $this->deviceArr[DeviceType::Did_AQ806][self::EVENT] = Aq806RespType::Event;
        // aph300 S04
        $this->deviceArr[DeviceType::Did_APH300] = [];
        $this->deviceArr[DeviceType::Did_APH300][self::LOGIN] = Aph300RespType::Login;
        $this->deviceArr[DeviceType::Did_APH300][self::HEART_BEAT] = Aph300RespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_APH300][self::DEVICE_INFO] = Aph300RespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_APH300][self::FIRMWARE_UPDATE] = Aph300RespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_APH300][self::CONTROL] = Aph300RespType::Control;
        $this->deviceArr[DeviceType::Did_APH300][self::EVENT] = Aph300RespType::Event;
        // 变频水泵 S05
        $this->deviceArr[DeviceType::Did_WaterPump] = [];
        $this->deviceArr[DeviceType::Did_WaterPump][self::LOGIN] = WaterPumpRespType::Login;
        $this->deviceArr[DeviceType::Did_WaterPump][self::HEART_BEAT] = WaterPumpRespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_WaterPump][self::DEVICE_INFO] = WaterPumpRespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_WaterPump][self::FIRMWARE_UPDATE] = WaterPumpRespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_WaterPump][self::CONTROL] = WaterPumpRespType::Control;
        $this->deviceArr[DeviceType::Did_WaterPump][self::EVENT] = WaterPumpRespType::Event;
        // ADT S06
        $this->deviceArr[DeviceType::Did_ADT] = [];
        $this->deviceArr[DeviceType::Did_ADT][self::LOGIN] = AdtRespType::Login;
        $this->deviceArr[DeviceType::Did_ADT][self::HEART_BEAT] = AdtRespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_ADT][self::DEVICE_INFO] = AdtRespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_ADT][self::FIRMWARE_UPDATE] = AdtRespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_ADT][self::CONTROL] = AdtRespType::Control;
        $this->deviceArr[DeviceType::Did_ADT][self::EVENT] = AdtRespType::Event;

        // Cp1000 S07
        $this->deviceArr[DeviceType::Did_CP1000] = [];
        $this->deviceArr[DeviceType::Did_CP1000][self::LOGIN] = Cp1000RespType::Login;
        $this->deviceArr[DeviceType::Did_CP1000][self::HEART_BEAT] = Cp1000RespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_CP1000][self::DEVICE_INFO] = Cp1000RespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_CP1000][self::FIRMWARE_UPDATE] = Cp1000RespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_CP1000][self::CONTROL] = Cp1000RespType::Control;
        $this->deviceArr[DeviceType::Did_CP1000][self::EVENT] = Cp1000RespType::Event;
        // aq118 S08
        $this->deviceArr[DeviceType::Did_AQ118] = [];
        $this->deviceArr[DeviceType::Did_AQ118][self::LOGIN] = Aq118RespType::Login;
        $this->deviceArr[DeviceType::Did_AQ118][self::HEART_BEAT] = Aq118RespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_AQ118][self::DEVICE_INFO] = Aq118RespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_AQ118][self::FIRMWARE_UPDATE] = Aq118RespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_AQ118][self::CONTROL] = Aq118RespType::Control;
        $this->deviceArr[DeviceType::Did_AQ118][self::EVENT] = Aq118RespType::Event;
        // feeder S09
        $this->deviceArr[DeviceType::Did_Feeder] = [];
        $this->deviceArr[DeviceType::Did_Feeder][self::LOGIN] = FeederRespType::Login;
        $this->deviceArr[DeviceType::Did_Feeder][self::HEART_BEAT] = FeederRespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_Feeder][self::DEVICE_INFO] = FeederRespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_Feeder][self::FIRMWARE_UPDATE] = FeederRespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_Feeder][self::CONTROL] = FeederRespType::Control;
        $this->deviceArr[DeviceType::Did_Feeder][self::EVENT] = FeederRespType::Event;
        // pet_feeder S10
        $this->deviceArr[DeviceType::Did_PetFeeder] = [];
        $this->deviceArr[DeviceType::Did_PetFeeder][self::LOGIN] = PetFeederRespType::Login;
        $this->deviceArr[DeviceType::Did_PetFeeder][self::HEART_BEAT] = PetFeederRespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_PetFeeder][self::DEVICE_INFO] = PetFeederRespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_PetFeeder][self::FIRMWARE_UPDATE] = PetFeederRespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_PetFeeder][self::CONTROL] = PetFeederRespType::Control;
        $this->deviceArr[DeviceType::Did_PetFeeder][self::EVENT] = PetFeederRespType::Event;
        // pet_feederV2 S11
        $this->deviceArr[DeviceType::Did_FeederV2] = [];
        $this->deviceArr[DeviceType::Did_FeederV2][self::LOGIN] = PetFeederRespType::Login;
        $this->deviceArr[DeviceType::Did_FeederV2][self::HEART_BEAT] = PetFeederRespType::Heartbeat;
        $this->deviceArr[DeviceType::Did_FeederV2][self::DEVICE_INFO] = PetFeederRespType::DeviceInfo;
        $this->deviceArr[DeviceType::Did_FeederV2][self::FIRMWARE_UPDATE] = PetFeederRespType::FirmwareUpdate;
        $this->deviceArr[DeviceType::Did_FeederV2][self::CONTROL] = PetFeederRespType::Control;
        $this->deviceArr[DeviceType::Did_FeederV2][self::EVENT] = PetFeederRespType::Event;

    }
}