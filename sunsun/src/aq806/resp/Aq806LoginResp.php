<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\resp;


use sunsun\aq806\req\Aq806LoginReq;
use sunsun\po\BaseRespPo;

class Aq806LoginResp extends BaseRespPo
{
    private $hb;
    private $tm;
    private $state;

    public function __construct(Aq806LoginReq $req = null)
    {
        $this->setRespType(Aq806RespType::Login);
        if ($req != null) {
            $this->setSn($req->getSn());
        }
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
            'state' => $this->state,
            'tm' => $this->getTm(),
            'hb' => $this->getHb()
        ];
    }


}