<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="city")
     * @ORM\JoinColumn(nullable=true)
     */
    private $activity;

  
    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Hebergement", mappedBy="city")
    * @ORM\JoinColumn(nullable=true)
    */
    private $hebergements;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="city")
    * @ORM\JoinColumn(nullable=true)
    */
    private $activities;

    /**
     * @ORM\Column(type="integer")
     */
    private $postcode;

    public function __construct()
    {
        $this->hebergement = new ArrayCollection();
        $this->hebergements = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->activity = new ArrayCollection();
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

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return Collection<int, Hebergement>
     */
    public function getHebergement(): Collection
    {
        return $this->hebergement;
    }

    public function addHebergement(Hebergement $hebergement): self
    {
        if (!$this->hebergement->contains($hebergement)) {
            $this->hebergement[] = $hebergement;
            $hebergement->setCity($this);
        }

        return $this;
    }

    public function removeHebergement(Hebergement $hebergement): self
    {
        if ($this->hebergement->removeElement($hebergement)) {
            // set the owning side to null (unless already changed)
            if ($hebergement->getCity() === $this) {
                $hebergement->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hebergement>
     */
    public function getHebergements(): Collection
    {
        return $this->hebergements;
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

    public function addActivity(Activity $activity): self
    {
        if (!$this->activity->contains($activity)) {
            $this->activity[] = $activity;
            $activity->setCity($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activity->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getCity() === $this) {
                $activity->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }
}
