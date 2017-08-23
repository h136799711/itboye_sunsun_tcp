<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-08-11
 * Time: 15:44
 */

namespace sunsun\model;


class DeviceTcpClientModel extends BaseModel
{
    private $did;
    private $tcp_client_id;
    private $prev_login_time;

    /**
     * @return mixed
     */
    public function getPrevLoginTime()
    {
        return $this->prev_login_time;
    }

    /**
     * @param mixed $prev_login_time
     */
    public function setPrevLoginTime($prev_login_time)
    {
        $this->prev_login_time = $prev_login_time;
    }

    /**
     * @return mixed
     */
    public function getDid()
    {
        return $this->did;
    }

    /**
     * @param mixed $did
     */
    public function setDid($did)
    {
        $this->did = $did;
    }

    /**
     * @return mixed
     */
    public function getTcpClientId()
    {
        return $this->tcp_client_id;
    }

    /**
     * @param mixed $tcp_client_id
     */
    public function setTcpClientId($tcp_client_id)
    {
        $this->tcp_client_id = $tcp_client_id;
    }
}