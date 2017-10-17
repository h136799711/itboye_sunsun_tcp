<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-17
 * Time: 10:43
 */

namespace sunsun\server\req;


use sunsun\po\BaseReqPo;

abstract class BaseDeviceFirmwareUpdateServerReq extends BaseReqPo
{
    private $url;//V512	固件下载地址	HTTP地址
    private $len;//固件字节长度


    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
            'url' => $this->getUrl(),
            'len' => $this->getLen()
        ];
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getLen()
    {
        return $this->len;
    }

    /**
     * @param mixed $len
     */
    public function setLen($len)
    {
        $this->len = $len;
    }
}