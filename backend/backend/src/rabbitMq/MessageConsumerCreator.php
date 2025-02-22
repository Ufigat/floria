<?php

namespace App\rabbitMq;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;

class MessageConsumerCreator implements ConsumerInterface
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository
    ) {
    }

    public function execute($msg): bool
    {
        $messageData = json_decode($msg->getBody(), true);

        if ($messageData === null) {
            echo "Error decoding message JSON.\n";
            return ConsumerInterface::MSG_REJECT;
        }

        $this->notificationRepository->save(new Notification(
            recipientEmail: $messageData['to'] ?? '',
            senderEmail: $messageData['from'] ?? '',
            message: $messageData['body'] ?? ''
        ));

        return ConsumerInterface::MSG_ACK;
    }
}