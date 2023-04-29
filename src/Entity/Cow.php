<?php

namespace App\Entity;

use App\Repository\CowRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert ;

#[ORM\Entity(repositoryClass: CowRepository::class)]
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

    #[ORM\Column(length: 50)]
    private ?string $breed = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $birth = null;

    
    public function __construct()
    {
        $this->birth = new \DateTimeImmutable() ;
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

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(string $breed): self
    {
        $this->breed = $breed;

        return $this;
    }

    public function getBirth(): ?\DateTimeImmutable
    {
        return $this->birth;
    }

    public function setBirth(\DateTimeImmutable $birth): self
    {
        $this->birth = $birth;

        return $this;
    }
}
