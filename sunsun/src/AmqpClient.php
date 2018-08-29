<?php
/**
 * Created by PhpStorm.
 * User: itboye
 * Date: 2018/8/29
 * Time: 13:51
 */

namespace sunsun;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpClient
{
    /**
     * @var AMQPStreamConnection
     */
    public $connection;
    /**
     * @var AMQPChannel
     */
    public $channel;
    protected $host;
    protected $port;
    protected $user;
    protected $pass;
    protected $vhost;
    protected $exchange = 'router';
    protected $queue = 'msgs';
    protected $consumerTag = 'consumer';

    public function __construct($host, $port, $user, $pass, $vhost = "/")
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        $this->vhost = $vhost;
    }

    public function openConnection() {
        $this->connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass, $this->vhost);
        $this->channel = $this->connection->channel();
    }

    /**
     * 删除队列之后会关闭链接，所以之后必须重新链接
     * @param $queueName
     */
    public function deleteQueue($queueName) {
        $this->channel->queue_declare($queueName, true);
        $this->channel->queue_delete($queueName);
        $this->closeConnection();
    }

    public function closeConnection() {

        try {
            if (($this->connection instanceof AMQPStreamConnection) && $this->connection->isConnected()) {
                if ($this->channel instanceof AMQPChannel) {
                    $this->channel->close();
                }
                $this->connection->close();
            }
        } catch (\ErrorException $e) {
        }
    }

    /**
     * 绑定队列以及交换机
     * @param $queueName
     * @param $exchangeName
     * @param array $queueOptions
     * @param array $exchangeOptions
     */
    public function bindQueueAndExchange($queueName, $exchangeName, $queueOptions = [
        'durable' => true, // 持久化 服务重启后数据能恢复
        'exclusive' => false, // ：排他队列，如果一个队列被声明为排他队列，该队列仅对首次声明它的连接可见，并在连接断开时自动删除。这里需要注意三点：其一，排他队列是基于连接可见的，同一连接的不同信道是可以同时访问同一个连接创建的排他队列的。其二，“首次”，如果一个连接已经声明了一个排他队列，其他连接是不允许建立同名的排他队列的，这个与普通队列不同。其三，即使该队列是持久化的，一旦连接关闭或者客户端退出，该排他队列都会被自动删除的。这种队列适用于只限于一个客户端发送读取消息的应用场景。
        'auto_delete' => false // 是否自动删除 在channel关闭的时候
    ], $exchangeOptions = [
        'type' => 'direct',
        'durable' => true,
        'auto_delete' => false
    ]) {
        $exchangeOptions = array_merge(['type' => 'direct', 'durable' => true, 'auto_delete' => false], $exchangeOptions);
        $queueOptions = array_merge(['exclusive'=>false, 'durable' => true, 'auto_delete' => false], $queueOptions);

        $this->channel->queue_declare($queueName, false,
            $queueOptions['durable'], $queueOptions['exclusive'], $queueOptions['auto_delete']);
        $this->channel->exchange_declare($exchangeName, $exchangeOptions['type'],
            false, $exchangeOptions['durable'], $exchangeOptions['auto_delete']);
        $this->channel->queue_bind($queueName, $exchangeName);
    }

    public function publish($exchangeName , $content = '', $deliveryMode = AMQPMessage::DELIVERY_MODE_PERSISTENT) {
        if ($content instanceof AMQPMessage) {
            $message = $content;
        } elseif (is_string($content)) {
            $message = new AMQPMessage($content, array('content_type' => 'text/plain', 'delivery_mode' => $deliveryMode));
        } elseif (is_array($content)) {
            $message = new AMQPMessage(json_encode($content), array('content_type' => 'text/plain', 'delivery_mode' => $deliveryMode));
        } else {
            $message = new AMQPMessage(json_encode($content), array('content_type' => 'text/plain', 'delivery_mode' => $deliveryMode));
        }

        $this->channel->basic_publish($message, $exchangeName);
    }

    public function consumer($queue, $consumerTag, $consumerOptions = [
        'no_local' => false,
        'no_ack' => false,
        'exclusive' => false,
        'nowait' => false,
        'callback' => null,
        'ticket' => null,
    ]) {

        $consumerOptions = array_merge([
            'no_local' => false,
            'no_ack' => false,
            'exclusive' => false,
            'nowait' => false,
            'callback' => null,
            'ticket' => null,
        ], $consumerOptions);

        /*
            queue: Queue from where to get the messages
            consumer_tag: Consumer identifier
            no_local: Don't receive messages published by this consumer.
            no_ack: Tells the server if the consumer will acknowledge the messages.
            exclusive: Request exclusive consumer access, meaning only this consumer can access the queue
            nowait:
            callback: A PHP Callback
        */
        $this->channel->basic_consume($queue, $consumerTag, $consumerOptions['no_local'], $consumerOptions['no_ack'],
            $consumerOptions['exclusive'], $consumerOptions['nowait'], $consumerOptions['callback']);

        // Loop as long as the channel has callbacks registered
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}