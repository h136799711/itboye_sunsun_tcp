<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-16
 * Time: 11:49
 */

namespace sunsun\server\resp;


use sunsun\po\BaseRespPo;

abstract class BaseHeartBeatServerResp extends BaseRespPo
{

    public function setData($data = null)
    {
        if (!empty($data) && is_array($data)) {
            if (array_key_exists('sn', $data)) {
                $this->setSn($data['sn']);
            }
        }
    }

    public function toDataArray()
    {
        return [
            'resType' => $this->getRespType(),
            'sn' => $this->getSn()
        ];
    }

}