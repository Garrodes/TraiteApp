<?php

namespace App\Entity;

use App\Repository\PeseeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeseeRepository::class)]
class Pesee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pesees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cow $ref_cow = null;

    #[ORM\Column]
    private ?float $volume = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefCow(): ?Cow
    {
        return $this->ref_cow;
    }

    public function setRefCow(?Cow $ref_cow): self
    {
        $this->ref_cow = $ref_cow;

        return $this;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
