<?php

namespace App\Entity;

use App\Repository\RedigeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RedigeRepository::class)]
class Redige
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'redige', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?rapportveterinaire $rapportveterinaire = null;

    public function getId(): ?int
    {
        return $this->id;
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
