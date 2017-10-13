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
 * 获取设备状态
 * @package sunsun\cp1000\req
 */
class Cp1000DeviceInfoReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(Cp1000ReqType::DeviceInfo);
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