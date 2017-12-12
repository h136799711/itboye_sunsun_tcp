<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-27
 * Time: 23:18
 */

namespace sunsun\model;


class LogModel extends BaseModel
{
    public function toDataArray()
    {
        return [
            'body' => $this->getBody(),
            'owner' => $this->getOwner(),
            'level' => $this->getLevel(),
            'type' => $this->getType(),
            'create_time' => time(),
            'remote_ip' => $this->getRemoteIp(),
            'remote_port' => $this->getRemotePort(),
            'gateway_ip' => $this->getGatewayIp(),
            'gateway_port' => $this->getGatewayPort(),
        ];
    }

    public function __construct()
    {
        $this->setRemoteIp('');
        $this->setRemotePort('');
        $this->setGatewayIp('');
        $this->setGatewayPort('');
    }

    private $remoteIp;
    private $remotePort;
    private $gatewayIp;
    private $gatewayPort;
    private $owner;
    private $body;
    private $level;
    private $type;

    /**
     * @return mixed
     */
    public function getRemoteIp()
    {
        return $this->remoteIp;
    }

    /**
     * @param mixed $remoteIp
     */
    public function setRemoteIp($remoteIp)
    {
        $this->remoteIp = $remoteIp;
    }

    /**
     * @return mixed
     */
    public function getRemotePort()
    {
        return $this->remotePort;
    }

    /**
     * @param mixed $remotePort
     */
    public function setRemotePort($remotePort)
    {
        $this->remotePort = $remotePort;
    }

    /**
     * @return mixed
     */
    public function getGatewayIp()
    {
        return $this->gatewayIp;
    }

    /**
     * @param mixed $gatewayIp
     */
    public function setGatewayIp($gatewayIp)
    {
        $this->gatewayIp = $gatewayIp;
    }

    /**
     * @return mixed
     */
    public function getGatewayPort()
    {
        return $this->gatewayPort;
    }

    /**
     * @param mixed $gatewayPort
     */
    public function setGatewayPort($gatewayPort)
    {
        $this->gatewayPort = $gatewayPort;
    }


    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }


    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }


}