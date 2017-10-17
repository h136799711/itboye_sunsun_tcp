<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\cp1000\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class Cp1000DeviceEventReq
 * 设备事件
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceEventReq extends BaseDeviceEventClientReq
{

    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            'mode' => $this->getMode(),
            'gear' => $this->getGear()
        ];
    }


    public function __construct($data = null)
    {
        parent::__construct($data);
        if (!empty($data)) {
            $this->setMode(-1);
            $this->setGear(-1);
            if (array_key_exists("mode", $data)) {
                $this->setMode($data['mode']);
            }

            if (array_key_exists("gear", $data)) {
                $this->setGear($data['gear']);
            }
        }
        $this->setReqType(Cp1000ReqType::Event);
    }


    // 成员变量

    private $mode;
    private $gear;


    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return mixed
     */
    public function getGear()
    {
        return $this->gear;
    }

    /**
     * @param mixed $gear
     */
    public function setGear($gear)
    {
        $this->gear = $gear;
    }


}