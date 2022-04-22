<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("activity:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("activity:read", "activity:wrtite")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups("activity:read", "activity:wrtite")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups("activity:read", "activity:wrtite")
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("activity:read", "activity:wrtite")
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("activity:read")
     */
    private $imageLarge;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("activity:read")
     */
    private $imageMedium;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("activity:read")
     */
    private $imageSmall;


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



    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    public function setPostcode(int $postcode): self
    {
        $this->postcode = $postcode;

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

    public function getImageLarge(): ?string
    {
        return $this->imageLarge;
    }

    public function setImageLarge(?string $imageLarge): self
    {
        $this->imageLarge = $imageLarge;

        return $this;
    }

    public function getImageMedium(): ?string
    {
        return $this->imageMedium;
    }

    public function setImageMedium(?string $imageMedium): self
    {
        $this->imageMedium = $imageMedium;

        return $this;
    }

    public function getImageSmall(): ?string
    {
        return $this->imageSmall;
    }

    public function setImageSmall(?string $imageSmall): self
    {
        $this->imageSmall = $imageSmall;

        return $this;
    }
    
}
