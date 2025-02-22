<?php

namespace App\rabbitMq;

use App\Repository\NotificationRepository;
use Exception;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;

class MessageConsumerTaker implements ConsumerInterface
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly MessageProducer        $messageProducer
    )
    {
    }

    public function execute($msg): bool
    {
        $messageData = json_decode($msg->getBody(), true);
        if ($messageData === null) {
            echo "Error decoding message JSON.\n";
            return ConsumerInterface::MSG_REJECT;
        }

        $page = $messageData['page'] ?? 1;
        $limit = $messageData['limit'] ?? 10;

        $notifications = $this->notificationRepository
            ->findWithPagination(
                $page,
                $limit
            );

        $totalPages = ceil($notifications->count() / $messageData['limit']);

        try {
            $this->messageProducer->sendMessage(json_encode([
                'page' => $page,
                'limit' => $limit,
                'totalPages' => $totalPages,
                'notifications' => $notifications->getIterator()->getArrayCopy(),
            ]));
        } catch (Exception $exception) {
            echo $exception->getMessage() . "\n";
            return ConsumerInterface::MSG_REJECT;
        }

        return ConsumerInterface::MSG_ACK;
    }
}