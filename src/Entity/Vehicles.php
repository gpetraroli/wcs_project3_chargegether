<?php

namespace App\Entity;

use App\Repository\VehiclesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiclesRepository::class)]
class Vehicles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 80)]
    private string $brand;

    #[ORM\Column(type: 'string', length: 80)]
    private string $model;

    #[ORM\Column(type: 'smallint')]
    private int $batteryCapacity;

    #[ORM\Column(type: 'string', length: 45)]
    private string $plugType;

    #[ORM\Column(type: 'smallint')]
    private int $batteryPower;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getBatteryCapacity(): int
    {
        return $this->batteryCapacity;
    }

    public function setBatteryCapacity(int $batteryCapacity): void
    {
        $this->batteryCapacity = $batteryCapacity;
    }

    public function getPlugType(): string
    {
        return $this->plugType;
    }

    public function setPlugType(string $plugType): void
    {
        $this->plugType = $plugType;
    }

    public function getBatteryPower(): int
    {
        return $this->batteryPower;
    }

    public function setBatteryPower(int $batteryPower): void
    {
        $this->batteryPower = $batteryPower;
    }
}
