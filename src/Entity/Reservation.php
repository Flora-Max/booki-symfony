<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityNight;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityPeople;

    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date")
     */
    private $firstNightDate;

  
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hebergement", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $hebergement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantityNight(): ?int
    {
        return $this->quantityNight;
    }

    public function setQuantityNight(int $quantityNight): self
    {
        $this->quantityNight = $quantityNight;

        return $this;
    }

    public function getQuantityPeople(): ?int
    {
        return $this->quantityPeople;
    }

    public function setQuantityPeople(int $quantityPeople): self
    {
        $this->quantityPeople = $quantityPeople;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getFirstNightDate(): ?\DateTimeInterface
    {
        return $this->firstNightDate;
    }

    public function setFirstNightDate(\DateTimeInterface $firstNightDate): self
    {
        $this->firstNightDate = $firstNightDate;

        return $this;
    }

    public function getHebergement(): ?Hebergement
    {
        return $this->hebergement;
    }

    public function setHebergement(?Hebergement $hebergement): self
    {
        $this->hebergement = $hebergement;

        return $this;
    }


}
