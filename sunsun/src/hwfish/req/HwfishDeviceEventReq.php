<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\hwfish\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class HwfishDeviceEventReq
 * 设备事件
 * @package sunsun\hwfish\req
 */
class HwfishDeviceEventReq extends BaseDeviceEventClientReq
{
    private $t;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HwfishReqType::Event);
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