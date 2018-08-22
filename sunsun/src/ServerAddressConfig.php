<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * User: hebidu<346551990@qq.com>
 * Date: 2017-10-20 13:50
 * Copyright: ${year} www.itboye.com Boye Inc. All rights reserved.
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-10-20 13:50
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

namespace sunsun;


class ServerAddressConfig
{

    // member function

    public static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new ServerAddressConfig();
        }

        return self::$instance;
    }

    // construct
    public function __construct()
    {
        $this->registerAddress = '172.16.23.85';
    }

    // override function __toString()

    // member variables
    private static $instance;
    private $registerAddress;


    // getter setter


    /**
     * @return mixed
     */
    public function getRegisterAddress()
    {
        return $this->registerAddress;
    }

    /**
     * @param mixed $registerAddress
     */
    public function setRegisterAddress($registerAddress)
    {
        $this->registerAddress = $registerAddress;
    }


}