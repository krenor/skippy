<?php

namespace Skippy;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class Skippy
{
    /**
     * The current AMQP connection.
     *
     * @var AMQPStreamConnection
     */
    protected $connection;

    /**
     * The current AMQP channel.
     *
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * The AMQP message to be sent.
     *
     * @var AMQPMessage
     */
    protected $message;

    /**
     * AMQP configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Skippy constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->connection = $this->buildConnection();
        $this->channel = $this->connection->channel();
    }

    /**
     * Create a message to be sent.
     *
     * @param mixed $content
     * @param bool $json
     *
     * @return $this
     */
    public function send($content, $json = false)
    {
        if (is_array($content) || $json === true) {
            $content = json_encode($content);
        }

        $message = new AMQPMessage($content, $this->config['message']);

        $this->message = $message;

        return $this;
    }

    /**
     * Send a message directly to a queue.
     *
     * @param string|null $queueName
     *
     * @return void
     */
    public function queue($queueName = null)
    {
        $queue = $queueName ?? $this->config['queue'] ?? null;

        $this->channel->queue_declare($queue, false, true, false, false);

        $this->channel->exchange_declare(
            $this->config['exchange']['name'],
            $this->config['exchange']['type'],
            false,
            true,
            false
        );

        $this->channel->queue_bind($queue, $this->config['exchange']['name']);

        $this->channel->basic_publish(
            $this->message,
            $this->config['exchange']['name'],
            $queueName
        );
    }

    /**
     * Publish the message on a given exchange.
     *
     * @param string|null $exchangeName
     * @param string|null $exchangeType
     * @param string $routingKey
     *
     * @return void
     */
    public function publish($exchangeName = null, $exchangeType = null, $routingKey = '')
    {
        $exchange = $exchangeName ?? $this->config['exchange']['name'];

        $type = $exchangeType ?? $this->config['exchange']['type'];

        $this->channel->exchange_declare(
            $exchange,
            $type,
            false,
            true,
            false
        );

        $this->channel->basic_publish(
            $this->message,
            $exchange,
            $routingKey
        );
    }

    /**
     * @return AMQPStreamConnection
     */
    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * @return AMQPMessage
     */
    public function getMessage(): AMQPMessage
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * Connect to an AMQP server.
     *
     * @return AMQPStreamConnection
     */
    private function buildConnection()
    {
        $connection = new AMQPStreamConnection(
            $this->config['connection']['host'],
            $this->config['connection']['port'],
            $this->config['connection']['username'],
            $this->config['connection']['password']
        );

        return $connection;
    }
}
