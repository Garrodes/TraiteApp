<?php

namespace App\Entity;

use App\Repository\InfoTraiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoTraiteRepository::class)]
class InfoTraite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToMany(targetEntity: Cow::class, mappedBy: 'cow_infotraite')]
    private Collection $cows;

    public function __construct()
    {
        $this->cows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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
            $cow->addCowInfotraite($this);
        }

        return $this;
    }

    public function removeCow(Cow $cow): self
    {
        if ($this->cows->removeElement($cow)) {
            $cow->removeCowInfotraite($this);
        }

        return $this;
    }
}
