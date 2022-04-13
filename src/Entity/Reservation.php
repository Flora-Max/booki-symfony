<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Groups("reservation:read")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     * @Groups("reservation:read")
     */
    private $quantityNight;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     * @Groups("reservation:read")
     */
    private $quantityPeople;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups("reservation:read")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Groups("reservation:read")
     */
    private $firstNightDate;

  
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hebergement", inversedBy="reservations")
     * @ORM\JoinColumn(name="hebergement_id", referencedColumnName="id",nullable=true)
     * @Groups("reservation:read")
     */
    private $hebergement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct()
    {
        $this->creationDate = new \DateTime("now"); // on génère un objet DateTime configuré à l'instant de la génération de notre instance d'entity
    }
   

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
