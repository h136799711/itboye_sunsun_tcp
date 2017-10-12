<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 10:07
 */

namespace sunsun\server\vo;

/**
 * Class RetVO
 * 处理结果对象，用于表示结果是否处理成功
 * @package sunsun\server\vo
 */
class RetVO
{
    public static function fail($data, $msg, $code=-1)
    {
        return (new RetVO($data, $msg, $code));
    }

    public static function success($data=[], $msg='success', $code=0)
    {
        return (new RetVO($data, $msg, $code));
    }

    /**
     * 从json字符串中初始化
     * @param $jsonStr
     */
    public function initFromJsonString($jsonStr)
    {
        $decode = json_decode($jsonStr, JSON_OBJECT_AS_ARRAY);
        if (array_key_exists('data', $decode)) {
            $this->setData($decode['data']);
        }
        if (array_key_exists('msg', $decode)) {
            $this->setMsg($decode['msg']);
        }
        if (array_key_exists('code', $decode)) {
            $this->setCode($decode['code']);
        }
    }

    public function __construct($data = '', $msg = '', $code = 0)
    {
        $this->setCode($code);
        $this->setData($data);
        $this->setMsg($msg);
    }

    public function __toString()
    {
        return json_encode(['code'=>$this->getCode(), 'data'=>$this->getData(), 'msg'=>$this->getMsg()]);
    }


    private $code;
    private $data;
    private $msg;

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

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }
}