<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 20:05
 */

namespace sunsun\feederV2\model;


use sunsun\model\BaseModel;

class FeederV2DeviceModel extends BaseModel
{
    private $did;
    private $pwd;
    private $tcpClientId;
    private $ver;
    private $lastLoginTime;
    private $hb;
    private $lastLoginIp;
    private $updateTime;

    public function toDataArray()
    {
        return [
            'did' => $this->getDid(),
            'ver' => $this->getVer(),
            'pwd' => $this->getPwd(),
            'last_login_time' => $this->getLastLoginTime(),
            'hb' => $this->getHb(),
            'tcp_client_id' => $this->getTcpClientId(),
            'last_login_ip' => $this->getLastLoginIp(),
            'create_time' => $this->getCreateTime(),
            'update_time' => $this->getUpdateTime()
        ];
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

    /**
     * @return mixed
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * @param mixed $lastLoginTime
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    /**
     * @return mixed
     */
    public function getHb()
    {
        return $this->hb;
    }

    /**
     * @param mixed $hb
     */
    public function setHb($hb)
    {
        $this->hb = $hb;
    }

    /**
     * @return mixed
     */
    public function getTcpClientId()
    {
        return $this->tcpClientId;
    }

    /**
     * @param mixed $tcpClientId
     */
    public function setTcpClientId($tcpClientId)
    {
        $this->tcpClientId = $tcpClientId;
    }

    /**
     * @return mixed
     */
    public function getLastLoginIp()
    {
        return $this->lastLoginIp;
    }

    /**
     * @param mixed $lastLoginIp
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->lastLoginIp = $lastLoginIp;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param mixed $updateTime
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    }

}