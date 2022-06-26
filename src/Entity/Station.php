<?php

namespace App\Entity;

use App\Config\PlugType;
use App\Config\StationPower;
use App\Repository\StationsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: StationsRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $address;

    #[ORM\Column(type: 'string', length: 45, enumType: PlugType::class)]
    private PlugType $plugType;

    #[ORM\Column(type: 'smallint', enumType: StationPower::class)]
    private StationPower $power;

    #[ORM\Column(type: 'text', nullable: true)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'stations')]
    #[ORM\JoinColumn(nullable: false)]
    private User|UserInterface $owner;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getPlugType(): PlugType
    {
        return $this->plugType;
    }

    public function setPlugType(PlugType $plugType): void
    {
        $this->plugType = $plugType;
    }

    public function getPower(): StationPower
    {
        return $this->power;
    }

    public function setPower(StationPower $power): void
    {
        $this->power = $power;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getOwner(): null|User|UserInterface
    {
        return $this->owner;
    }

    public function setOwner(null|User|UserInterface $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
