<?php

namespace App\Entity;

use App\Repository\BookingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingsRepository::class)]
class Bookings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeImmutable $startRes;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeImmutable $endRes;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeImmutable $startLoc;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeImmutable $endLoc;

    #[ORM\Column(type: 'smallint')]
    private int $batteryLevelStart;

    #[ORM\Column(type: 'smallint')]
    private int $batteryLevelEnd;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

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

    public function getStartLoc(): \DateTimeImmutable
    {
        return $this->startLoc;
    }

    public function setStartLoc(\DateTimeImmutable $startLoc): void
    {
        $this->startLoc = $startLoc;
    }

    public function getEndLoc(): \DateTimeImmutable
    {
        return $this->endLoc;
    }

    public function setEndLoc(\DateTimeImmutable $endLoc): void
    {
        $this->endLoc = $endLoc;
    }

    public function getBatteryLevelStart(): int
    {
        return $this->batteryLevelStart;
    }

    public function setBatteryLevelStart(int $batteryLevelStart): void
    {
        $this->batteryLevelStart = $batteryLevelStart;
    }

    public function getBatteryLevelEnd(): int
    {
        return $this->batteryLevelEnd;
    }

    public function setBatteryLevelEnd(int $batteryLevelEnd): void
    {
        $this->batteryLevelEnd = $batteryLevelEnd;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
