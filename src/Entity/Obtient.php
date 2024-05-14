<?php

namespace App\Entity;

use App\Repository\ObtientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObtientRepository::class)]
class Obtient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'obtient')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\OneToOne(inversedBy: 'obtient', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?rapportveterinaire $rapportveterinaire = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRapportveterinaire(): ?rapportveterinaire
    {
        return $this->rapportveterinaire;
    }

    public function setRapportveterinaire(rapportveterinaire $rapportveterinaire): static
    {
        $this->rapportveterinaire = $rapportveterinaire;

        return $this;
    }
}
