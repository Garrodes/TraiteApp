<?php

namespace App\Entity;

use App\Repository\VolumeCowHerdRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert ;

#[ORM\Entity(repositoryClass: VolumeCowHerdRepository::class)]
class VolumeCowHerd
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive()]
    private ?float $volume = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $date = null;

    public function __construct()
    {
        $this->date = new \DateTimeImmutable() ;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }
}
