<?php

namespace App\Entity;

use App\Repository\HerdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert ;

#[ORM\Entity(repositoryClass: HerdRepository::class)]
class Herd
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotNull()]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Positive()]
    private ?float $water = null;

    #[ORM\Column]
    #[Assert\Positive()]
    private ?float $food = null;

    #[ORM\OneToMany(mappedBy: 'ref_herd', targetEntity: Cow::class)]
    private Collection $cows;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FoodUnit $foodUnit = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    private int $cowCount;

    public function __construct()
    {
        $this->cows = new ArrayCollection();
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

    public function getWater(): ?float
    {
        return $this->water;
    }

    public function setWater(float $water): self
    {
        $this->water = $water;

        return $this;
    }

    public function getFood(): ?float
    {
        return $this->food;
    }

    public function setFood(float $food): self
    {
        $this->food = $food;

        return $this;
    }

    /**
     * @return Collection<int, Cow>
     */
    public function getCows(): Collection
    {
        return $this->cows;
    }

    public function addCow(Cow $cow): self
    {
        if (!$this->cows->contains($cow)) {
            $this->cows->add($cow);
            $cow->setRefHerd($this);
        }

        return $this;
    }

    public function removeCow(Cow $cow): self
    {
        if ($this->cows->removeElement($cow)) {
            // set the owning side to null (unless already changed)
            if ($cow->getRefHerd() === $this) {
                $cow->setRefHerd(null);
            }
        }

        return $this;
    }

    public function getFoodUnit(): ?FoodUnit
    {
        return $this->foodUnit;
    }

    public function setFoodUnit(?FoodUnit $foodUnit): self
    {
        $this->foodUnit = $foodUnit;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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

    public function getCowCount()
    {
        return $this->cowCount = $this->cows->count();   
    }


}
