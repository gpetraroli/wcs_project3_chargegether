<?php

namespace App\Entity;

use App\Config\PlugType;
use App\Config\StationPower;
use App\Repository\StationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationsRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $address;

    #[ORM\Column(type: 'json')]
    private string $coordinates;

    #[ORM\Column(type: 'string', length: 45, enumType: PlugType::class)]
    private PlugType $plugType;

    #[ORM\Column(type: 'smallint', enumType: StationPower::class)]
    private StationPower $power;

    #[ORM\Column(type: 'text', nullable: true)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'stations')]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Booking::class, orphanRemoval: true, cascade: ['all'])]
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: StationReview::class, orphanRemoval: true, cascade: ['all'])]
    private Collection $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function getReviews(): Collection
    {
        return $this->reviews;
    }
    public function setReviews(Collection $reviews): void
    {
        $this->reviews = $reviews;
    }


    public function getBookings(): Collection
    {
        return $this->bookings;
    }
    public function setBookings(Collection $bookings): void
    {
        $this->bookings = $bookings;
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

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCoordinates(): string
    {
        return $this->coordinates;
    }

    public function setCoordinates(string $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setStation($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getStation() === $this) {
                $booking->setStation(null);
            }
        }

        return $this;
    }

    public function addReview(StationReview $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setStation($this);
        }

        return $this;
    }

    public function removeReview(StationReview $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getStation() === $this) {
                $review->setStation(null);
            }
        }

        return $this;
    }
}
