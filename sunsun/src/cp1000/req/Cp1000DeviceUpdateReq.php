<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\req;

use sunsun\po\BaseReqPo;

/**
 * Class Cp1000HbReq
 * 设备更新请求
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceUpdateReq extends BaseReqPo
{

    private $url;//V512	固件下载地址	HTTP地址
    private $len;//固件字节长度


    public function __construct($data = null)
    {
        $this->setReqType(Cp1000ReqType::FirmwareUpdate);
        if (!empty($data)) {
            $this->setSn($data['sn']);
        }
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