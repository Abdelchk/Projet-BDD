<?php

namespace App\Entity;

use App\Repository\DestinationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DestinationRepository::class)]
class Destination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $url_imgs = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adresse $id_adresse = null;

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

    public function getUrlImgs(): ?string
    {
        return $this->url_imgs;
    }

    public function setUrlImgs(string $url_imgs): static
    {
        $this->url_imgs = $url_imgs;

        return $this;
    }

    public function getIdAdresse(): ?Adresse
    {
        return $this->id_adresse;
    }

    public function setIdAdresse(Adresse $id_adresse): static
    {
        $this->id_adresse = $id_adresse;

        return $this;
    }
}
