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

    public function __construct($data = null)
    {
        parent::__construct($data);
        if (!empty($data) && array_key_exists('code', $data)) {
            $this->setCode($data['code']);
        }
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn()
        ];
    }

    private $code;

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