<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\heating_rod\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * Class HeatingRodHbReq
 * 设备事件
 * @package sunsun\heating_rod\req
 */
class HeatingRodDeviceEventReq extends BaseDeviceEventClientReq
{
    private $t;

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

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(HeatingRodReqType::Event);
        if (!empty($data)) {
            $this->setT($data['t']);
        }
    }

}