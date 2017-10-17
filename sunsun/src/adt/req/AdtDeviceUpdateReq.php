<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\adt\req;

use sunsun\po\BaseReqPo;

/**
 * Class AdtHbReq
 * 设备更新请求
 * @package sunsun\adt\req
 */
class AdtDeviceUpdateReq extends BaseReqPo
{

    private $url;//V512	固件下载地址	HTTP地址
    private $len;//固件字节长度


    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(AdtReqType::FirmwareUpdate);
    }

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