<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'meals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'meals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $employee = null;

    #[ORM\OneToOne(mappedBy: 'meal', cascade: ['persist', 'remove'])]
    private ?VeterinaryReport $veterinaryReport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function getEmployee(): ?User
    {
        return $this->employee;
    }

    public function setEmployee(?User $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function getVeterinaryReport(): ?VeterinaryReport
    {
        return $this->veterinaryReport;
    }

    public function setVeterinaryReport(?VeterinaryReport $veterinaryReport): static
    {
        // unset the owning side of the relation if necessary
        if ($veterinaryReport === null && $this->veterinaryReport !== null) {
            $this->veterinaryReport->setMeal(null);
        }

        // set the owning side of the relation if necessary
        if ($veterinaryReport !== null && $veterinaryReport->getMeal() !== $this) {
            $veterinaryReport->setMeal($this);
        }

        $this->veterinaryReport = $veterinaryReport;

        return $this;
    }
}
