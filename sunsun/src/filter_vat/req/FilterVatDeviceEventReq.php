<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\req;

use sunsun\po\BaseReqPo;

/**
 * Class FilterVatHbReq
 * 设备事件
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceEventReq extends BaseReqPo
{
    private $code;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->setReqType(FilterVatReqType::Event);
        if (!empty($data)) {
            $this->setCode($data['code']);
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