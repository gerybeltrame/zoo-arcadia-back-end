<?php

namespace App\Entity;

use App\Repository\RapportVeterinaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportVeterinaireRepository::class)]
class RapportVeterinaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 50)]
    private ?string $detail = null;

    #[ORM\OneToOne(mappedBy: 'rapportveterinaire', cascade: ['persist', 'remove'])]
    private ?Obtient $obtient = null;

    #[ORM\OneToOne(mappedBy: 'rapportveterinaire', cascade: ['persist', 'remove'])]
    private ?Redige $redige = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    public function getObtient(): ?Obtient
    {
        return $this->obtient;
    }

    public function setObtient(Obtient $obtient): static
    {
        // set the owning side of the relation if necessary
        if ($obtient->getRapportveterinaire() !== $this) {
            $obtient->setRapportveterinaire($this);
        }

        $this->obtient = $obtient;

        return $this;
    }

    public function getRedige(): ?Redige
    {
        return $this->redige;
    }

    public function setRedige(Redige $redige): static
    {
        // set the owning side of the relation if necessary
        if ($redige->getRapportveterinaire() !== $this) {
            $redige->setRapportveterinaire($this);
        }

        $this->redige = $redige;

        return $this;
    }
}
