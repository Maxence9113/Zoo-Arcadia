<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Race $race = null;

    /**
     * @var Collection<int, AnimalPicture>
     */
    #[ORM\OneToMany(targetEntity: AnimalPicture::class, mappedBy: 'animal', orphanRemoval: true, cascade: ['persist'])] 
    private Collection $animalPictures;

    public function __construct()
    {
        $this->animalPictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }

    /**
     * @return Collection<int, AnimalPicture>
     */
    public function getAnimalPictures(): Collection
    {
        return $this->animalPictures;
    }

    public function addAnimalPicture(AnimalPicture $animalPicture): static
    {
        if (!$this->animalPictures->contains($animalPicture)) {
            $this->animalPictures->add($animalPicture);
            $animalPicture->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalPicture(AnimalPicture $animalPicture): static
    {
        if ($this->animalPictures->removeElement($animalPicture)) {
            // set the owning side to null (unless already changed)
            if ($animalPicture->getAnimal() === $this) {
                $animalPicture->setAnimal(null);
            }
        }

        return $this;
    }
}
