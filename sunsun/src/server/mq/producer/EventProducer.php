<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * @author    hebidu<346551990@qq.com>
 * @copyright 2017 www.itboye.com Boye Inc. All rights reserved.
 * @link      http://www.itboye.com/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-11-25 14:43
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

namespace sunsun\server\mq\producer;


use by\component\mq\config\MQConfig;
use by\component\mq\core\Queue;
use by\component\mq\exchanges\DirectExchange;
use by\component\mq\message\JsonMessage;
use by\component\mq\producer\DefaultProducer;

class EventProducer extends DefaultProducer
{
    public $exchangeName;
    public $queueName;
    public $routingKey;
    public $ttl;

    public function __construct(MQConfig $config, $name = '')
    {
        parent::__construct($config, $name);
        $this->exchangeName = "sunsun_exchange";
        $this->queueName = "aq806_queue";
        $this->routingKey = 'com.sunsunxiaoli.aq806.event';
        $this->ttl = 20 * 60 * 1000;
    }

    public function init()
    {
        // 定义路由交换机
        $exchange = new DirectExchange($this->exchangeName);
        // 定义队列
        $queue = new Queue($this->queueName);
        $queue->setPassive(false);
        $queue->setTtl($this->ttl);

        $this->ready($queue, $exchange, $this->routingKey);
    }

    /**
     * 发送消息
     * @param string $message
     */
    public function send($message)
    {
        $msg = new JsonMessage();
        $msg->setExpiration($this->ttl / 2);
        $msg->setImmeadiate(false);
        $msg->setBody($message);
        $this->produce($msg);
    }
}