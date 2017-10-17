<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 14:17
 */

namespace sunsun\server\interfaces;


interface RespFactoryInterface
{
    function create($resType, $jsonData);
}