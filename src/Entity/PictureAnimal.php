<?php

namespace App\Entity;

use App\Repository\PictureAnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureAnimalRepository::class)]
class PictureAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionAlt = null;

    #[ORM\ManyToOne(inversedBy: 'pictureAnimals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDescriptionAlt(): ?string
    {
        return $this->descriptionAlt;
    }

    public function setDescriptionAlt(?string $descriptionAlt): static
    {
        $this->descriptionAlt = $descriptionAlt;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }
}
