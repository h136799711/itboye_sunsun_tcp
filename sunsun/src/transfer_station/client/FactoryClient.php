<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-09-27
 * Time: 14:37
 */

namespace sunsun\transfer_station\client;


use sunsun\server\consts\DeviceType;
use sunsun\transfer_station\interfaces\DeviceClientInterface;

class FactoryClient
{
    /**
     * @param $did
     * @return null|DeviceClientInterface
     */
    public static function createClient($did)
    {

        $type = DeviceType::getDeviceType($did);
        switch ($type) {
            case DeviceType::Did_FilterVat:
                return new FilterClient();
                break;
            case DeviceType::Did_WaterPump:
                return new WaterPumpClient();
                break;
            case DeviceType::Did_AQ806:
                return new Aq806Client();
                break;
            case DeviceType::Did_APH300:
                return new AphClient();
                break;
            case DeviceType::Did_HeatingRod:
                return new HeatingRodClient();
                break;
            case DeviceType::Did_ADT:
                return new AdtClient();
                break;
            case DeviceType::Did_CP1000:
                return new Cp1000Client();
                break;
            default:
                break;
        }
        return null;
    }

    public static function getInfo($client_id,$did,$pwd){
        $type = DeviceType::getDeviceType($did);
        switch ($type){
            case DeviceType::Did_FilterVat:
                (new FilterClient())->getInfo($client_id,$did,$pwd);
                break;
            case DeviceType::Did_WaterPump:
                (new WaterPumpClient())->getInfo($client_id,$did,$pwd);
                break;
            case DeviceType::Did_AQ806:
                (new Aq806Client())->getInfo($client_id,$did,$pwd);
                break;
            case DeviceType::Did_APH300:
                (new AphClient())->getInfo($client_id,$did,$pwd);
                break;
            case DeviceType::Did_HeatingRod:
                (new HeatingRodClient())->getInfo($client_id,$did,$pwd);
                break;
            case DeviceType::Did_ADT:
                (new AdtClient())->getInfo($client_id,$did,$pwd);
                break;
            case DeviceType::Did_CP1000:
                (new Cp1000Client())->getInfo($client_id, $did, $pwd);
                break;
            default:
                break;
        }
    }
}