<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 11:26
 */

namespace sunsun\server\req;


use sunsun\po\BaseReqPo;

abstract class BaseDeviceEventClientReq extends BaseReqPo
{
    public function getEventInfo()
    {
        return $this->toDataArray();
    }

    public function __construct($data = null)
    {
        parent::__construct($data);
        if (!empty($data) && array_key_exists('code', $data)) {
            $this->setCode($data['code']);
        }
        if (!empty($data) && array_key_exists('m', $data)) {
            $this->setM($data['m']);
        }
        if (!empty($data) && array_key_exists('cam_did', $data)) {
            $this->setCamDid($data['cam_did']);
        }
        if (!empty($data) && array_key_exists('cam_pwd', $data)) {
            $this->setCamPwd($data['cam_pwd']);
        }
        if (!empty($data) && array_key_exists('file', $data)) {
            $this->setFile($data['file']);
        }
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
            'code' => $this->getCode(),
            'm' => $this->getM(),
            'file' => $this->getFile(),
            'cam_did' => $this->getCamDid(),
            'cam_pwd' => $this->getCamPwd()
        ];
    }

    private $file;
    private $camDid;
    private $camPwd;
    private $m;

    private $code;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getCamDid()
    {
        return $this->camDid;
    }

    /**
     * @param mixed $camDid
     */
    public function setCamDid($camDid)
    {
        $this->camDid = $camDid;
    }

    /**
     * @return mixed
     */
    public function getCamPwd()
    {
        return $this->camPwd;
    }

    /**
     * @param mixed $camPwd
     */
    public function setCamPwd($camPwd)
    {
        $this->camPwd = $camPwd;
    }

    /**
     * @return mixed
     */
    public function getM()
    {
        return $this->m;
    }

    /**
     * @param mixed $m
     */
    public function setM($m)
    {
        $this->m = $m;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

}