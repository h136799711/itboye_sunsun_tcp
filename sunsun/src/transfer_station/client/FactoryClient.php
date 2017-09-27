<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 14:37
 */

namespace sunsun\transfer_station\client;


use sunsun\server\consts\DeviceType;

class FactoryClient
{
    public static function getInfo($did,$pwd){
        $type = DeviceType::getDeviceType($did);
        switch ($type){
            case DeviceType::Did_FilterVat:
                (new FilterClient())->getInfo($did,$pwd);
                break;
            case DeviceType::Did_WaterPump:
                (new WaterPumpClient())->getInfo($did,$pwd);
                break;
            case DeviceType::Did_AQ806:
                (new Aq806Client())->getInfo($did,$pwd);
                break;
            case DeviceType::Did_APH300:
                (new AphClient())->getInfo($did,$pwd);
                break;
            case DeviceType::Did_HeatingRod:
                (new HeatingRodClient())->getInfo($did,$pwd);
                break;
            case DeviceType::Did_ADT:
                (new AdtClient())->getInfo($did,$pwd);
                break;
            default:

                break;
        }
    }
}