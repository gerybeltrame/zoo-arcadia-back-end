<?php

namespace App\Entity;

use App\Repository\DetientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetientRepository::class)]
class Detient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, habitat>
     */
    #[ORM\OneToMany(targetEntity: habitat::class, mappedBy: 'detient')]
    private Collection $habitat;

    #[ORM\OneToOne(mappedBy: 'detient', cascade: ['persist', 'remove'])]
    private ?Animal $animal = null;

    public function __construct()
    {
        $this->habitat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, habitat>
     */
    public function getHabitat(): Collection
    {
        return $this->habitat;
    }

    public function addHabitat(habitat $habitat): static
    {
        if (!$this->habitat->contains($habitat)) {
            $this->habitat->add($habitat);
            $habitat->setDetient($this);
        }

        return $this;
    }

    public function removeHabitat(habitat $habitat): static
    {
        if ($this->habitat->removeElement($habitat)) {
            // set the owning side to null (unless already changed)
            if ($habitat->getDetient() === $this) {
                $habitat->setDetient(null);
            }
        }

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): static
    {
        // set the owning side of the relation if necessary
        if ($animal->getDetient() !== $this) {
            $animal->setDetient($this);
        }

        $this->animal = $animal;

        return $this;
    }
}
