<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-16
 * Time: 11:40
 */

namespace sunsun\server\interfaces;


use sunsun\adt\resp\AdtRespFactory;
use sunsun\cp1000\resp\Cp1000RespFactory;
use sunsun\server\consts\DeviceType;

class RespFacadeFactory
{
    /**
     * @param $deviceType
     * @return null|AdtRespFactory|Cp1000RespFactory
     */
    public static function createRespFactory($deviceType)
    {
        $factory = null;
        switch ($deviceType) {
            case DeviceType::Did_CP1000:
                $factory = new Cp1000RespFactory();
                break;
            case DeviceType::Did_ADT:
                $factory = new AdtRespFactory();
                break;
            default:
                break;
        }
        return $factory;
    }

    public static function createResp($respType, $deviceType, $jsonData)
    {
        $factory = self::createRespFactory($deviceType);
        if ($factory != null) {
            return $factory->create($respType, $jsonData);
        }
        return null;
    }

    public static function createRespHeartBeatType($deviceType)
    {
        switch ($deviceType) {

        }
    }
}