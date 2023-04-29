<?php

namespace App\Entity;

use App\Repository\CowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert ;

#[ORM\Entity(repositoryClass: CowRepository::class)]
#[UniqueEntity('name')]
class Cow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:1, max:50)]
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dob = null;

    #[ORM\ManyToOne(inversedBy: 'cows')]
    private ?Herd $ref_herd = null;

    #[ORM\ManyToOne(inversedBy: 'cows')]
    private ?Breed $breed = null;

    #[ORM\OneToMany(mappedBy: 'ref_cow', targetEntity: Pesee::class)]
    private Collection $pesees;

    #[ORM\ManyToMany(targetEntity: Health::class, inversedBy: 'cows')]
    private Collection $cow_health;

    #[ORM\ManyToMany(targetEntity: InfoTraite::class, inversedBy: 'cows')]
    private Collection $cow_infotraite;

    public function __construct()
    {
        $this->pesees = new ArrayCollection();
        $this->cow_health = new ArrayCollection();
        $this->cow_infotraite = new ArrayCollection();
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

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function getRefHerd(): ?Herd
    {
        return $this->ref_herd;
    }

    public function setRefHerd(?Herd $ref_herd): self
    {
        $this->ref_herd = $ref_herd;

        return $this;
    }

    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    public function setBreed(?Breed $breed): self
    {
        $this->breed = $breed;

        return $this;
    }

    /**
     * @return Collection<int, Pesee>
     */
    public function getPesees(): Collection
    {
        return $this->pesees;
    }

    public function addPesee(Pesee $pesee): self
    {
        if (!$this->pesees->contains($pesee)) {
            $this->pesees->add($pesee);
            $pesee->setRefCow($this);
        }

        return $this;
    }

    public function removePesee(Pesee $pesee): self
    {
        if ($this->pesees->removeElement($pesee)) {
            // set the owning side to null (unless already changed)
            if ($pesee->getRefCow() === $this) {
                $pesee->setRefCow(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Health>
     */
    public function getCowHealth(): Collection
    {
        return $this->cow_health;
    }

    public function addCowHealth(Health $cowHealth): self
    {
        if (!$this->cow_health->contains($cowHealth)) {
            $this->cow_health->add($cowHealth);
        }

        return $this;
    }

    public function removeCowHealth(Health $cowHealth): self
    {
        $this->cow_health->removeElement($cowHealth);

        return $this;
    }

    /**
     * @return Collection<int, InfoTraite>
     */
    public function getCowInfotraite(): Collection
    {
        return $this->cow_infotraite;
    }

    public function addCowInfotraite(InfoTraite $cowInfotraite): self
    {
        if (!$this->cow_infotraite->contains($cowInfotraite)) {
            $this->cow_infotraite->add($cowInfotraite);
        }

        return $this;
    }

    public function removeCowInfotraite(InfoTraite $cowInfotraite): self
    {
        $this->cow_infotraite->removeElement($cowInfotraite);

        return $this;
    }

}