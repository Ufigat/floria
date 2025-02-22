<?php

namespace App\rabbitMq;

use OldSound\RabbitMqBundle\RabbitMq\Producer;

class MessageProducer
{
    public function __construct(
        private readonly Producer $producer
    ) {
    }

    public function sendMessage(string $message): void
    {
        $this->producer->publish($message, 'read');
    }
}