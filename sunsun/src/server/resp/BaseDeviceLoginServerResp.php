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
        $this->hb = $hb;
    }

    /**
     * @return mixed
     */
    public function getHb()
    {
        return $this->hb;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
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
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'state' => $this->getState(),
            'tm' => $this->getTm(),
            'hb' => $this->getHb()
        ];
    }

    public function setData($data = null)
    {
        if (empty($data)) return;
        array_key_exists('sn', $data) && $this->setSn($data['sn']);
        array_key_exists('state', $data) && $this->setState($data['state']);
        array_key_exists('hb', $data) && $this->setState($data['hb']);
    }
}