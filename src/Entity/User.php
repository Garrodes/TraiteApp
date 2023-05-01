<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\EntityListener\UserListener;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners([UserListener::class])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    
    private ?string $plainPassword = null ;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?string $password = 'password';

    #[ORM\Column(length: 50)]
    #[Assert\Length(min:2, max:50)]
    #[Assert\NotBlank()]
    private ?string $fullName = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length( max:50)]
    private ?string $pseudo = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Cow::class, orphanRemoval: true)]
    private Collection $cows;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: VolumeCowHerd::class, orphanRemoval: true)]
    private Collection $volumecowherd;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable() ;
        $this->updatedAt = new \DateTimeImmutable() ;
        $this->cows = new ArrayCollection();
        $this->volumecowherd = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword ;
    }

    public function setPlainPassword($plainPassword)
    {
        return $this->plainPassword = $plainPassword; 
    }
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
            $cow->setUser($this);
        }

        return $this;
    }

    public function removeCow(Cow $cow): self
    {
        if ($this->cows->removeElement($cow)) {
            // set the owning side to null (unless already changed)
            if ($cow->getUser() === $this) {
                $cow->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, VolumeCowHerd>
     */
    public function getVolumecowherd(): Collection
    {
        return $this->volumecowherd;
    }

    public function addVolumecowherd(VolumeCowHerd $volumecowherd): self
    {
        if (!$this->volumecowherd->contains($volumecowherd)) {
            $this->volumecowherd->add($volumecowherd);
            $volumecowherd->setUser($this);
        }

        return $this;
    }

    public function removeVolumecowherd(VolumeCowHerd $volumecowherd): self
    {
        if ($this->volumecowherd->removeElement($volumecowherd)) {
            // set the owning side to null (unless already changed)
            if ($volumecowherd->getUser() === $this) {
                $volumecowherd->setUser(null);
            }
        }

        return $this;
    }
}
