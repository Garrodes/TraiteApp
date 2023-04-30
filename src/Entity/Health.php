<?php

namespace App\Entity;

use App\Repository\HealthRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HealthRepository::class)]
class Health
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $state = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function __toString()
    {
        return $this->state ;
    }


}
