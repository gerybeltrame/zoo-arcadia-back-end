<?php

namespace App\Entity;

use App\Repository\PossedeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PossedeRepository::class)]
class Possede
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, role>
     */
    #[ORM\OneToMany(targetEntity: role::class, mappedBy: 'possede', orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $role;

    #[ORM\OneToOne(mappedBy: 'possede', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->role = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, role>
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(role $role): static
    {
        if (!$this->role->contains($role)) {
            $this->role->add($role);
            $role->setPossede($this);
        }

        return $this;
    }

    public function removeRole(role $role): static
    {
        if ($this->role->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getPossede() === $this) {
                $role->setPossede(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): static
    {
        // set the owning side of the relation if necessary
        if ($utilisateur->getPossede() !== $this) {
            $utilisateur->setPossede($this);
        }

        $this->utilisateur = $utilisateur;

        return $this;
    }
}
