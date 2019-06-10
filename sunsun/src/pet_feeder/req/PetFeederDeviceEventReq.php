<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\pet_feeder\req;

use sunsun\server\req\BaseDeviceEventClientReq;

/**
 * ClassPetFeederDeviceEventReq
 * 设备事件
 * @package sunsun\pet_feeder\req
 */
class PetFeederDeviceEventReq extends BaseDeviceEventClientReq
{
    // 成员变量
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(PetFeederReqType::Event);

        if (!empty($data) && array_key_exists('fc', $data)) {
            $this->setFc($data['fc']);
        }
    }

    protected $fc;

    /**
     * @return mixed
     */
    public function getFc()
    {
        return $this->fc;
    }

    /**
     * @param mixed $fc
     */
    public function setFc($fc)
    {
        $this->fc = $fc;
    }

    function toDataArray()
    {
        $arr = parent::toDataArray();
        $arr['fc'] = $this->getFc();
    }
}
