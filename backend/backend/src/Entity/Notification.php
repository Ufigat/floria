<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Table(name: 'notifications')]
#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $recipientEmail;

    #[ORM\Column(length: 255)]
    private string $senderEmail;

    #[ORM\Column(type: "text")]
    private string $message;

    public function __construct(
        string $recipientEmail,
        string $senderEmail,
        string $message
    ) {
        $this->recipientEmail = $recipientEmail;
        $this->senderEmail = $senderEmail;
        $this->message = $message;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRecipientEmail(): string
    {
        return $this->recipientEmail;
    }

    public function setRecipientEmail(string $recipientEmail): self
    {
        $this->recipientEmail = $recipientEmail;
        return $this;
    }

    public function getSenderEmail(): string
    {
        return $this->senderEmail;
    }

    public function setSenderEmail(string $senderEmail): self
    {
        $this->senderEmail = $senderEmail;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'recipientEmail' => $this->recipientEmail,
            'senderEmail' => $this->senderEmail,
            'message' => $this->message,
        ];
    }
}
