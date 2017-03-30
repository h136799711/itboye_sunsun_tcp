<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\req;


use sunsun\po\BaseReqPo;

class HeatingRodLoginReq extends BaseReqPo
{
    private $did;
    private $ver;
    private $pwd;


    public function __construct($data=null)
    {
        $this->setReqType(HeatingRodReqType::Login);
        if(!empty($data)){
            $this->setSn($data['sn']);
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
            'reqType'=>$this->getReqType(),
            'sn'=>$this->getSn(),
            'did'=>$this->getDid(),
            'ver'=>$this->getVer(),
            'pwd'=>$this->getPwd(),
        ];
    }


}