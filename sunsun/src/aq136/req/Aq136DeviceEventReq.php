<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq136\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class Aq136DeviceEventReq
 * 设备事件
 * @package sunsun\aq136\req
 */
class Aq136DeviceEventReq extends BaseDeviceEventClientReq
{
    private $t;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(Aq136ReqType::Event);
        if (!empty($data)) {
            $this->setT(-1);
            if (array_key_exists("t", $data)) {
                $this->setT($data['t']);
            }
        }
    }

    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            't' => $this->getT()
        ];
    }

    /**
     * @return mixed
     */
    public function getT()
    {
        return $this->t;
    }

    /**
     * @param mixed $t
     */
    public function setT($t)
    {
        $this->t = $t;
    }

    function toDataArray()
    {
        return array_merge(parent::toDataArray(), [
            't' => $this->getT()
        ]);
    }

}