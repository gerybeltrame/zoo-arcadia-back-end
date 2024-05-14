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

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $etat = null;

    #[ORM\OneToOne(inversedBy: 'animal', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?detient $detient = null;

    #[ORM\OneToOne(inversedBy: 'animal', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?dispose $dispose = null;

    /**
     * @var Collection<int, obtient>
     */
    #[ORM\OneToMany(targetEntity: obtient::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $obtient;

    public function __construct()
    {
        $this->obtient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDetient(): ?detient
    {
        return $this->detient;
    }

    public function setDetient(detient $detient): static
    {
        $this->detient = $detient;

        return $this;
    }

    public function getDispose(): ?dispose
    {
        return $this->dispose;
    }

    public function setDispose(dispose $dispose): static
    {
        $this->dispose = $dispose;

        return $this;
    }

    /**
     * @return Collection<int, obtient>
     */
    public function getObtient(): Collection
    {
        return $this->obtient;
    }

    public function addObtient(obtient $obtient): static
    {
        if (!$this->obtient->contains($obtient)) {
            $this->obtient->add($obtient);
            $obtient->setAnimal($this);
        }

        return $this;
    }

    public function removeObtient(obtient $obtient): static
    {
        if ($this->obtient->removeElement($obtient)) {
            // set the owning side to null (unless already changed)
            if ($obtient->getAnimal() === $this) {
                $obtient->setAnimal(null);
            }
        }

        return $this;
    }
}
