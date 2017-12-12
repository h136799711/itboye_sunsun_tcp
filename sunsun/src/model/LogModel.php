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
            'owner' => $this->getOwner(),
            'body' => $this->getBody(),
            'level' => $this->getLevel(),
            'type' => $this->getType(),
            'ip' => $this->getIp()
        ];
    }

    public function __construct()
    {
        $this->setIp('');
    }

    private $ip;
    private $owner;
    private $body;
    private $level;
    private $type;

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
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