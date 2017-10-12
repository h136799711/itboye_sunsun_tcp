<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 14:43
 */

namespace sunsun\server\tcpChannelCommand;


use GatewayWorker\Lib\Gateway;

class CloseCommand implements TcpChannelCommandInterface
{
    private $client_id;

    function acceptParams($params)
    {
        if(array_key_exists('client_id', $params)){
            $this->client_id = $params['client_id'];
        }else{
            throw new \Exception('client_id is missing');
        }
    }

    function execute()
    {
        if ($this->client_id) {
            Gateway::closeClient($this->client_id);
        }
    }

}