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
     * @var Collection<int, PictureAnimal>
     */
    #[ORM\OneToMany(targetEntity: PictureAnimal::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $pictureAnimals;

    public function __construct()
    {
        $this->pictureAnimals = new ArrayCollection();
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
     * @return Collection<int, PictureAnimal>
     */
    public function getPictureAnimals(): Collection
    {
        return $this->pictureAnimals;
    }

    public function addPictureAnimal(PictureAnimal $pictureAnimal): static
    {
        if (!$this->pictureAnimals->contains($pictureAnimal)) {
            $this->pictureAnimals->add($pictureAnimal);
            $pictureAnimal->setAnimal($this);
        }

        return $this;
    }

    public function removePictureAnimal(PictureAnimal $pictureAnimal): static
    {
        if ($this->pictureAnimals->removeElement($pictureAnimal)) {
            // set the owning side to null (unless already changed)
            if ($pictureAnimal->getAnimal() === $this) {
                $pictureAnimal->setAnimal(null);
            }
        }

        return $this;
    }

}
