<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\aq806\req;

use sunsun\po\BaseReqPo;

/**
 * Class Aq806HbReq
 * 获取设备状态
 * @package sunsun\aq806\req
 */
class Aq806DeviceInfoReq extends BaseReqPo
{

    public function __construct($data = null)
    {
        $this->setReqType(Aq806ReqType::DeviceInfo);
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