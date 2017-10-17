<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 11:23
 */

namespace sunsun\server\req;


use sunsun\po\BaseReqPo;

/**
 * 设备登录请求
 * Class BaseDeviceLoginClientReq
 * @package sunsun\server\req
 */
abstract class BaseDeviceLoginClientReq extends BaseReqPo
{

    private $did;
    private $ver;
    private $pwd;

    public function __construct($data = null)
    {
        parent::__construct($data);
        if (!empty($data)) {
            $this->setDid($data['did']);
            $this->setVer($data['ver']);
            $this->setPwd($data['pwd']);
        }
    }

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
    public function getVer()
    {
        return $this->ver;
    }

    /**
     * @param mixed $ver
     */
    public function setVer($ver)
    {
        $this->ver = $ver;
    }

    /**
     * @return mixed
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * @param mixed $pwd
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
            'did' => $this->getDid(),
            'ver' => $this->getVer(),
            'pwd' => $this->getPwd(),
        ];
    }
}