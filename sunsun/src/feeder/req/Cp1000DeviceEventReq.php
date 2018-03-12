<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\feeder\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class FeederDeviceEventReq
 * 设备事件
 * @package sunsun\feeder\req
 */
class FeederDeviceEventReq extends BaseDeviceEventClientReq
{

    private $mode;
    private $gear;


    // 成员变量

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
        $this->setReqType(FeederReqType::Event);
    }

    public function getEventInfo()
    {
        return [
            'code' => $this->getCode(),
            'mode' => $this->getMode(),
            'gear' => $this->getGear()
        ];
    }

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