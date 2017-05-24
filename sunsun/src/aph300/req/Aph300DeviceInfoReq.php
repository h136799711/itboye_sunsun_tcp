<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aph300\req;

use sunsun\po\BaseReqPo;

/**
 * Class Aph300HbReq
 * 获取设备状态
 * @package sunsun\aph300\req
 */
class Aph300DeviceInfoReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(Aph300ReqType::DeviceInfo);
        if (!empty($data)) {
            $this->setSn($data['sn']);
        }
    }

    function toDataArray()
    {
        return [
            'reqType' => $this->getReqType(),
            'sn' => $this->getSn(),
        ];
    }


}