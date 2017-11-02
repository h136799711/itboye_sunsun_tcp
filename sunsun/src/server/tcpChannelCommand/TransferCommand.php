<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 2017-10-12
 * Time: 14:43
 */

namespace sunsun\server\tcpChannelCommand;


use GatewayWorker\Lib\Gateway;
use sunsun\transfer_station\client\TransferClient;

/**
 * Class TransferCommand
 * 消息转发指令
 * @package sunsun\server\tcpChannelCommand
 */
class TransferCommand implements TcpChannelCommandInterface
{
    private $client_id;

    function acceptParams($params)
    {
        if (array_key_exists('client_id', $params)) {
            $this->client_id = $params['client_id'];
        } else {
            throw new \Exception('client_id is missing');
        }
    }

    function execute()
    {
        if ($this->client_id) {
            $session = Gateway::getSession($this->client_id);
            $did = array_key_exists('did', $session) ? $session['did'] : '';
            if (!empty($did)) {
                TransferClient::sendMessageToGroup($did, $data, -1, 9);
            }
        }
    }

}