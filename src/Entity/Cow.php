<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CowRepository;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich ;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[Vich\Uploadable]
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

    #[ORM\OneToMany(mappedBy: 'cow', targetEntity: Pesee::class)]
    private Collection $pesees;

    #[ORM\ManyToMany(targetEntity: Health::class)]
    private Collection $healths;

   
    #[ORM\Column(nullable: true)]
    private ?int $idNat = null;

    #[ORM\ManyToOne(inversedBy: 'cows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $isPublic = false;

    #[ORM\OneToMany(mappedBy: 'cow', targetEntity: Mark::class, orphanRemoval: true)]
    private Collection $marks;

    private ?float $average = null ;

    #[Vich\UploadableField(mapping: 'cows', fileNameProperty: 'imageName',  size:'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;



    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $updatedAt=null;

    public function __construct()
    {
        $this->pesees = new ArrayCollection();
        $this->healths = new ArrayCollection();
        $this->marks = new ArrayCollection();
/*         $this->updatedAt = new \DateTimeImmutable() ; */
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
            $pesee->setCow($this);
        }

        return $this;
    }

    public function removePesee(Pesee $pesee): self
    {
        if ($this->pesees->removeElement($pesee)) {
            // set the owning side to null (unless already changed)
            if ($pesee->getCow() === $this) {
                $pesee->setCow(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Health>
     */
    public function getHealths(): Collection
    {
        return $this->healths;
    }

    public function addHealth(Health $health): self
    {
        if (!$this->healths->contains($health)) {
            $this->healths->add($health);
        }

        return $this;
    }

    public function removeHealth(Health $health): self
    {
        $this->healths->removeElement($health);

        return $this;
    }

    public function getIdNat(): ?int
    {
        return $this->idNat;
    }

    public function setIdNat(?int $idNat): self
    {
        $this->idNat = $idNat;

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

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * @return Collection<int, Mark>
     */
    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(Mark $mark): self
    {
        if (!$this->marks->contains($mark)) {
            $this->marks->add($mark);
            $mark->setCow($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): self
    {
        if ($this->marks->removeElement($mark)) {
            // set the owning side to null (unless already changed)
            if ($mark->getCow() === $this) {
                $mark->setCow(null);
            }
        }

        return $this;
    }

    public function getAverage()
    {
        $marks = $this ->marks;

        if($marks->toArray() === []){
            return $this->average = null ;
        }

        $total = 0;
        foreach($marks as $mark){
            $total += $mark->getMark();
        }

        $this->average = $total / count($marks) ;
        
        return $this->average ;
    }

    public function __toString()
    {
        return $this->name ;
    }


    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    

}
