<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 45)]
    private string $userName;

    #[ORM\Column(type: 'string', length: 500)]
    private string $password;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string', length: 80)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 80)]
    private string $lastName;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTime $birthDate = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $address;

    #[ORM\Column(type: 'string', length: 10)]
    private string $zipcode;

    #[ORM\Column(type: 'string', length: 80)]
    private string $city;

    #[ORM\Column(type: 'string', length: 80)]
    private string $country;

    #[ORM\Column(type: 'string', length: 45)]
    private string $gender;

    #[ORM\Column(type: 'string', length: 20, unique: true)]
    private string $phoneNumber;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private DateTime $updatedAt;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Station::class, orphanRemoval: true)]
    private Collection $stations;

    #[ORM\ManyToMany(targetEntity: Vehicle::class)]
    private Collection $vehicles;

    #[ORM\OneToMany(mappedBy: 'destinationUser', targetEntity: Notification::class, orphanRemoval: true)]
    private Collection $notifications;

    #[ORM\OneToMany(mappedBy: 'bookingUser', targetEntity: Booking::class, orphanRemoval: true)]
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: StationReview::class, orphanRemoval: true)]
    private Collection $reviews;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?UserImage $image = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = clone $this->createdAt;
        $this->stations = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }
    public function setReviews(Collection $reviews): void
    {
        $this->reviews = $reviews;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }
    public function setBirthDate(DateTime $birthDate = null): void
    {
        $this->birthDate = $birthDate;
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

    public function getZipcode(): string
    {
        return $this->zipcode;
    }
    public function setZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    public function getCity(): string
    {
        return $this->city;
    }
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getGender(): string
    {
        return $this->gender;
    }
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function setCreatedAt(datetime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(datetime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStations(): Collection
    {
        return $this->stations;
    }
    public function addStation(Station $station): self
    {
        if (!$this->stations->contains($station)) {
            $this->stations[] = $station;
            $station->setOwner($this);
        }

        return $this;
    }
    public function removeStation(Station $station): self
    {
        $this->stations->removeElement($station);

        return $this;
    }

    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }
    public function addVehicle(Vehicle $vehicle): self
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
        }
        return $this;
    }
    public function removeVehicle(Vehicle $vehicle): self
    {
        $this->vehicles->removeElement($vehicle);

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setDestinationUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getDestinationUser() === $this) {
                $notification->setDestinationUser(null);
            }
        }

        return $this;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setBookingUser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getBookingUser() === $this) {
                $booking->setBookingUser(null);
            }
        }

        return $this;
    }

    public function addReview(StationReview $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setOwner($this);
        }

        return $this;
    }

    public function removeReview(StationReview $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getOwner() === $this) {
                $review->setOwner(null);
            }
        }

        return $this;
    }

    public function getImage(): ?UserImage
    {
        return $this->image;
    }

    public function setImage(?UserImage $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }
}
