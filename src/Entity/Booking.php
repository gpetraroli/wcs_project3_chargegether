<?php

namespace App\Entity;

use App\Repository\BookingsRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: BookingsRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $startRes;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $endRes;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $startLoc;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $endLoc;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private string $bookingPrice;

    #[ORM\ManyToOne(targetEntity: Vehicle::class)]
    private Vehicle $vehicle;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    private Station $station;

    #[ORM\Column(type: 'boolean')]
    private bool $confirmed;

    // le mec qui réserve
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookings')]
    private User $bookingUser;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->startLoc = null;
        $this->endLoc = null;
        $this->confirmed = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStartRes(): \DateTimeImmutable
    {
        return $this->startRes;
    }

    public function setStartRes(\DateTimeImmutable $startRes): void
    {
        $this->startRes = $startRes;
    }

    public function getEndRes(): \DateTimeImmutable
    {
        return $this->endRes;
    }

    public function setEndRes(\DateTimeImmutable $endRes): void
    {
        $this->endRes = $endRes;
    }

    public function getStartLoc(): ?DateTimeImmutable
    {
        return $this->startLoc;
    }

    public function setStartLoc(\DateTimeImmutable $startLoc): void
    {
        $this->startLoc = $startLoc;
    }

    public function getEndLoc(): ?\DateTimeImmutable
    {
        return $this->endLoc;
    }

    public function setEndLoc(\DateTimeImmutable $endLoc): void
    {
        $this->endLoc = $endLoc;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getBookingPrice(): ?string
    {
        return $this->bookingPrice;
    }

    public function setBookingPrice(string $bookingPrice): self
    {
        $this->bookingPrice = $bookingPrice;

        return $this;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    public function getStation(): Station
    {
        return $this->station;
    }

    public function setStation(Station $station): void
    {
        $this->station = $station;
    }

    public function getBookingUser(): User
    {
        return $this->bookingUser;
    }

    public function setBookingUser(?User $user): void
    {
        $this->bookingUser = $user;
    }

        public function isConfirmed(): bool
    {
        return $this->confirmed;
    }
    public function setConfirmed(bool $confirmed): void
    {
        $this->confirmed = $confirmed;
    }


}
