<?php

namespace App\Entity;

use App\Repository\HabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitatRepository::class)]
class Habitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $commentaire_habitat = null;

    /**
     * @var Collection<int, comporte>
     */
    #[ORM\OneToMany(targetEntity: comporte::class, mappedBy: 'habitat', orphanRemoval: true)]
    private Collection $comporte;

    #[ORM\ManyToOne(inversedBy: 'habitat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Detient $detient = null;

    public function __construct()
    {
        $this->comporte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCommentaireHabitat(): ?string
    {
        return $this->commentaire_habitat;
    }

    public function setCommentaireHabitat(string $commentaire_habitat): static
    {
        $this->commentaire_habitat = $commentaire_habitat;

        return $this;
    }

    /**
     * @return Collection<int, comporte>
     */
    public function getComporte(): Collection
    {
        return $this->comporte;
    }

    public function addComporte(comporte $comporte): static
    {
        if (!$this->comporte->contains($comporte)) {
            $this->comporte->add($comporte);
            $comporte->setHabitat($this);
        }

        return $this;
    }

    public function removeComporte(comporte $comporte): static
    {
        if ($this->comporte->removeElement($comporte)) {
            // set the owning side to null (unless already changed)
            if ($comporte->getHabitat() === $this) {
                $comporte->setHabitat(null);
            }
        }

        return $this;
    }

    public function getDetient(): ?Detient
    {
        return $this->detient;
    }

    public function setDetient(?Detient $detient): static
    {
        $this->detient = $detient;

        return $this;
    }
}
