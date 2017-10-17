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
 * 获取设备状态
 * @package sunsun\adt\req
 */
class AdtDeviceInfoReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(AdtReqType::DeviceInfo);
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
        ];
    }


}