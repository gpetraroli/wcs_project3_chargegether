<?php

namespace App\Entity;

use App\Repository\NotificationsRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: NotificationsRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $body;

    #[ORM\Column(type: 'boolean')]
    private bool $isRead;

    #[ORM\Column(type: 'boolean')]
    private bool $needConfirmation;

    #[ORM\OneToOne(targetEntity: Booking::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Booking $booking;


    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private UserInterface $destinationUser;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->isRead = false;
        $this->needConfirmation = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): void
    {
        $this->isRead = $isRead;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDestinationUser(): ?UserInterface
    {
        return $this->destinationUser;
    }
    public function setDestinationUser(?UserInterface $destinationUser): self
    {
        $this->destinationUser = $destinationUser;

        return $this;
    }

    public function isNeedConfirmation(): bool
    {
        return $this->needConfirmation;
    }
    public function setNeedConfirmation(bool $needConfirmation): void
    {
        $this->needConfirmation = $needConfirmation;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }
    public function setBooking(?Booking $booking): void
    {
        $this->booking = $booking;
    }


}
