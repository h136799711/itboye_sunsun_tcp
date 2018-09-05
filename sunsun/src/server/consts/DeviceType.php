<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-10
 * Time: 15:33
 */

namespace  sunsun\server\consts;

class DeviceType
{
    // 【S01: 过滤桶】 【S02:加热棒】 【S03:森森806】 【S04:APH-300】 【S05:变频水泵】 【S06:ADT】
    // 【S07: CP1000水泵】
    // 【S08: aq118】
    const Did_FilterVat = 'S01';
    const Did_HeatingRod = 'S02';
    const Did_AQ806 = 'S03';
    const Did_APH300 = 'S04';
    const Did_WaterPump = 'S05';
    const Did_ADT = 'S06';
    const Did_CP1000 = 'S07';
    const Did_AQ118 = 'S08';
    const Did_Feeder = 'S09';
    const Did_PetFeeder = 'S10';
    const Did_Unknown= 'XXX';

    public static function getDeviceType($did){
        $type = strtoupper(substr($did,0,3));
        switch ($type){
            case DeviceType::Did_FilterVat:
                return DeviceType::Did_FilterVat;
                break;
            case DeviceType::Did_PetFeeder:
                return DeviceType::Did_PetFeeder;
                break;
            case DeviceType::Did_WaterPump:
                return DeviceType::Did_WaterPump;
                break;
            case DeviceType::Did_ADT:
                return DeviceType::Did_ADT;
                break;
            case DeviceType::Did_HeatingRod:
                return DeviceType::Did_HeatingRod;
                break;
            case DeviceType::Did_AQ806:
                return DeviceType::Did_AQ806;
                break;
            case DeviceType::Did_APH300:
                return DeviceType::Did_APH300;
                break;
            case DeviceType::Did_CP1000:
                return DeviceType::Did_CP1000;
                break;
            case DeviceType::Did_AQ118:
                return DeviceType::Did_AQ118;
                break;
            case DeviceType::Did_Feeder:
                return DeviceType::Did_Feeder;
                break;
            default:
                return DeviceType::Did_Unknown;
                break;

        }

    }

}