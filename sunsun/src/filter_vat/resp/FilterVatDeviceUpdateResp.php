<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-13
 * Time: 18:04
 */

namespace sunsun\filter_vat\resp;


use sunsun\filter_vat\req\FilterVatDeviceUpdateReq;
use sunsun\po\BaseRespPo;

/**
 * Class FilterVatHbReq
 * 心跳包
 * @package sunsun\filter_vat\req
 */
class FilterVatDeviceUpdateResp extends BaseRespPo
{

    private $state;

    public function __construct(FilterVatDeviceUpdateReq $req=null)
    {
        $this->setRespType(FilterVatRespType::FirmwareUpdate);
        if(!empty($req)){
            $this->setSn($req->getSn());
        }
    }

    public function setData($data){

        if(array_key_exists("state",$data)){
            $this->setState($data['state']);
        }else{
            //默认999
            $this->setState(999);
        }
    }

    public function toDataArray()
    {
        return [
            'resType'=>$this->getRespType(),
            'sn'=>$this->getSn()
        ];
    }

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


}