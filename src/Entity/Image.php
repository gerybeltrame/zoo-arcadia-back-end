<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?comporte $comporte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComporte(): ?comporte
    {
        return $this->comporte;
    }

    public function setComporte(?comporte $comporte): static
    {
        $this->comporte = $comporte;

        return $this;
    }
}
