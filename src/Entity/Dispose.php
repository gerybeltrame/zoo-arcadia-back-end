<?php

namespace App\Entity;

use App\Repository\DisposeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisposeRepository::class)]
class Dispose
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'dispose', cascade: ['persist', 'remove'])]
    private ?Animal $animal = null;

    /**
     * @var Collection<int, race>
     */
    #[ORM\OneToMany(targetEntity: race::class, mappedBy: 'dispose', orphanRemoval: true)]
    private Collection $race;

    public function __construct()
    {
        $this->race = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): static
    {
        // set the owning side of the relation if necessary
        if ($animal->getDispose() !== $this) {
            $animal->setDispose($this);
        }

        $this->animal = $animal;

        return $this;
    }

    /**
     * @return Collection<int, race>
     */
    public function getRace(): Collection
    {
        return $this->race;
    }

    public function addRace(race $race): static
    {
        if (!$this->race->contains($race)) {
            $this->race->add($race);
            $race->setDispose($this);
        }

        return $this;
    }

    public function removeRace(race $race): static
    {
        if ($this->race->removeElement($race) && $race->getDispose() === $this) {
            $race->setDispose(null);
        }

        return $this;
    }
}
