<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * User: hebidu<346551990@qq.com>
 * Date: 2017-10-19 10:50
 * Copyright: ${year} www.itboye.com Boye Inc. All rights reserved.
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-10-19 10:50
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

namespace sunsun\transfer_station\client\req;

use sunsun\transfer_station\client\interfaces\SetDataInterface;

/**
 * Class DeviceLoginReq
 * 客户端登录请求
 * @package sunsun\transfer_station\client\req
 */
class DeviceLoginReq implements SetDataInterface
{

    // member function
    public function setData($data = null)
    {
        array_key_exists('did', $data) && $this->setData($data['did']);
    }


    // construct
    public function __construct($data = null)
    {
        $this->setData($data);
    }

    // override function __toString()

    // member variables
    private $did;
    private $preDid;
    private $token;
    private $uid;
    private $sign;

    // getter setter

    /**
     * @return mixed
     */
    public function getDid()
    {
        return $this->did;
    }

    /**
     * @param mixed $did
     */
    public function setDid($did)
    {
        $this->did = $did;
    }

    /**
     * @return mixed
     */
    public function getPreDid()
    {
        return $this->preDid;
    }

    /**
     * @param mixed $preDid
     */
    public function setPreDid($preDid)
    {
        $this->preDid = $preDid;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    }

}