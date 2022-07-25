<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class StationReview
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'smallint')]
    private int $rate;

    #[ORM\Column(type: 'text', nullable: true)]
    private string $body;

    #[ORM\ManyToOne(targetEntity: Station::class, inversedBy: 'reviews')]
    private Station $station;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reviews')]
    private User $owner;


    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRate(): int
    {
        return $this->rate;
    }
    public function setRate(int $rate): void
    {
        $this->rate = $rate;
    }

    public function getBody(): string
    {
        return $this->body;
    }
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getStation(): Station
    {
        return $this->station;
    }
    public function setStation(Station $station): void
    {
        $this->station = $station;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }
}
