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

    #[ORM\ManyToMany(targetEntity: Cow::class)]
    private Collection $relatedCows;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->relatedCows = new ArrayCollection();
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
    public function getRelatedCows(): Collection
    {
        return $this->relatedCows;
    }

    public function addRelatedCow(Cow $relatedCow): self
    {
        if (!$this->relatedCows->contains($relatedCow)) {
            $this->relatedCows->add($relatedCow);
        }

        return $this;
    }

    public function removeRelatedCow(Cow $relatedCow): self
    {
        $this->relatedCows->removeElement($relatedCow);

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
