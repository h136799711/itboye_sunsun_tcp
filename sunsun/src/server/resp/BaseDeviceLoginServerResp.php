<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 10:22
 */

namespace sunsun\server\resp;


use sunsun\po\BaseRespPo;

class BaseDeviceLoginServerResp extends BaseRespPo
{

    private $hb;
    private $tm;
    private $state;
    private $serverAddress;
    private $serverPort;
    private $serverExpireTime;

    /**
     * 设置服务器信息
     * @param array $data
     */
    public function setServerInfo($data)
    {
        if (array_key_exists('server_address', $data)
            && array_key_exists('server_port', $data)
            && array_key_exists('server_expire_time', $data)) {
            $this->setServerAddress($data['server_address']);
            $this->setServerPort($data['server_port']);
            $this->setServerExpireTime($data['server_expire_time']);
        }
    }

    /**
     * 最大 0 - 3600 之间
     * @param mixed $serverExpireTime
     */
    public function setServerExpireTime($serverExpireTime)
    {
        $this->serverExpireTime = intval($serverExpireTime);
        if ($this->serverExpireTime > 3600) {
            $this->serverExpireTime = 3600;
        }

        if ($this->serverExpireTime < 0) {
            $this->serverExpireTime = 0;
        }
    }

    public function getServerExpireTime()
    {
        return $this->serverExpireTime;
    }

    /**
     * @return mixed
     */
    public function getServerAddress()
    {
        return $this->serverAddress;
    }

    /**
     * @param mixed $serverAddress
     */
    public function setServerAddress($serverAddress)
    {
        $this->serverAddress = $serverAddress;
    }

    /**
     * @return mixed
     */
    public function getServerPort()
    {
        return $this->serverPort;
    }

    /**
     * @param mixed $serverPort
     */
    public function setServerPort($serverPort)
    {
        $this->serverPort = $serverPort;
    }

    /**
     * 设置登录成功状态
     */
    public function setLoginSuccess()
    {
        $this->state = 0;
    }

    /**
     * 服务器拒绝该设备上线
     */
    public function setLoginFail()
    {
        $this->state = 1;
    }

    /**
     * @param mixed $hb
     */
    public function setHb($hb)
    {
        $this->hb = intval($hb);
    }

    /**
     * @return mixed
     */
    public function getHb()
    {
        return $this->hb;
    }

    /**
     * @return integer
     */
    public function getState()
    {
        return ($this->state);
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = intval($state);
    }

    /**
     * @return mixed
     */
    public function getTm()
    {
        $this->tm = gmdate("YmdHis");
        return $this->tm;
    }

    /**
     * 转换为数据数组
     * @return array
     */
    function toDataArray()
    {
        $data = [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'state' => $this->getState(),
            'tm' => $this->getTm(),
            'hb' => $this->getHb()
        ];

        if (!empty($this->getServerAddress()) && !empty($this->getServerPort()) && $this->getServerExpireTime() > 0) {
            $data['server_address'] = $this->getServerAddress();
            $data['server_port'] = $this->getServerPort();
            $data['server_expire_time'] = $this->getServerExpireTime();
        }

        return $data;
    }
}