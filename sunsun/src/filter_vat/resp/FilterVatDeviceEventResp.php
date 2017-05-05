<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\resp;


use sunsun\filter_vat\req\FilterVatDeviceEventReq;
use sunsun\po\BaseRespPo;

/**
 * Class FilterVatHbReq
 * 设备事件响应
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceEventResp extends BaseRespPo
{


    public function __construct(FilterVatDeviceEventReq $req = null)
    {
        $this->setRespType(FilterVatRespType::Event);
        if (!empty($req)) {
            $this->setSn($req->getSn());
        }
    }

    private $state;

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn(),
            'state' => $this->getState()
        ];
    }

}