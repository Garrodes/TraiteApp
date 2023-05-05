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
    private ?float $water_neededforone = null;

    #[ORM\Column]
    #[Assert\Positive()]
    private ?float $food_neededforone = null;

    #[ORM\OneToMany(mappedBy: 'ref_herd', targetEntity: Cow::class)]
    private Collection $cows;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FoodUnit $ref_foodUnit = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

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

    public function getWaterNeededforone(): ?float
    {
        return $this->water_neededforone;
    }

    public function setWaterNeededforone(float $water_neededforone): self
    {
        $this->water_neededforone = $water_neededforone;

        return $this;
    }

    public function getFoodNeededforone(): ?float
    {
        return $this->food_neededforone;
    }

    public function setFoodNeededforone(float $food_neededforone): self
    {
        $this->food_neededforone = $food_neededforone;

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

    public function getRefFoodUnit(): ?FoodUnit
    {
        return $this->ref_foodUnit;
    }

    public function setRefFoodUnit(?FoodUnit $ref_foodUnit): self
    {
        $this->ref_foodUnit = $ref_foodUnit;

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


}
