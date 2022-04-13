<?php

namespace App\Entity;

use App\Repository\HebergementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=HebergementRepository::class)
 */
class Hebergement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("hebergement:read")
     * @Groups("reservation:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("hebergement:read")
     * @Groups("reservation:read")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups("hebergement:read")
     * @Groups("reservation:read")
     */
    private $description;


    /**
     * @ORM\Column(type="integer")
     * @Groups("hebergement:read")
     */
    private $price;



    /**
     * @ORM\Column(type="integer")
     */
    private $postcode;

   
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="hebergement")
     * @ORM\JoinColumn(nullable=true)
     */
    private $reservations;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("hebergement:read")
     */
    private $city;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("hebergement:read")
     */
    private $trend;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("hebergement:read")
     */
    private $imageLarge;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("hebergement:read")
     */
    private $imageMedium;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("hebergement:read")
     */
    private $imageSmall;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("hebergement:read")
     */
    private $category;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    public function setPostcode(int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setHebergement($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHebergement() === $this) {
                $reservation->setHebergement(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTrend(): ?bool
    {
        return $this->trend;
    }

    public function setTrend(?bool $trend): self
    {
        $this->trend = $trend;

        return $this;
    }

    public function getImageLarge()
    {
        return $this->imageLarge;
    }

    public function setImageLarge($imageLarge): self
    {
        $this->imageLarge = $imageLarge;

        return $this;
    }

    public function getImageMedium()
    {
        return $this->imageMedium;
    }

    public function setImageMedium($imageMedium): self
    {
        $this->imageMedium = $imageMedium;

        return $this;
    }

    public function getImageSmall()
    {
        return $this->imageSmall;
    }

    public function setImageSmall($imageSmall): self
    {
        $this->imageSmall = $imageSmall;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    } 
}
