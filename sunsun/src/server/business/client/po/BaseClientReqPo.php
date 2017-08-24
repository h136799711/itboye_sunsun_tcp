<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-24
 * Time: 15:46
 */

namespace sunsun\server\business\client\po;


/**
 *
 * Class BaseClientReqPo
 * @package sunsun\server\business\po
 */
abstract class BaseClientReqPo
{
    abstract function parseJson();
}