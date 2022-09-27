<?php

namespace App\Services\Rabbit;

use App\Domain\Queue;
use App\Services\QueueInterface;
use Exception;
use Illuminate\Config\Repository;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitQueueManager implements QueueInterface
{
    private const MESSAGE_PROPERTIES = [
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
    ];
    private AMQPChannel $channel;
    private AMQPStreamConnection $connection;

    /**
     * @throws Exception
     */
    public function __construct(Repository $configRepository)
    {
        $this->connection = AMQPStreamConnection::create_connection($configRepository->get('rabbitmq'));
        $this->channel = $this->connection->channel();
    }

    /**
     * @throws Exception
     */
    public function publish(Queue $queue): void
    {
        $this->channel->queue_declare($queue->getQueue(), false, true, false, false);
        $msg = new AMQPMessage($queue->serialize(), self::MESSAGE_PROPERTIES);
        $this->channel->basic_publish($msg, routing_key: $queue->getQueue());
        $this->shutdown();
    }

    /**
     * @throws Exception
     */
    private function shutdown(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
