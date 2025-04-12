<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'profil', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Utilisateur $id_utilisateur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $preferences = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(Utilisateur $id_utilisateur): static
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPreferences(): ?string
    {
        return $this->preferences;
    }

    public function setPreferences(string $preferences): static
    {
        $this->preferences = $preferences;

        return $this;
    }

    public function getPreferencesArray(): array
{
    return $this->preferences ? explode(',', $this->preferences) : [];
}

public function addPreference(int $destinationId): static
{
    $preferences = $this->getPreferencesArray();
    if (!in_array($destinationId, $preferences)) {
        $preferences[] = $destinationId;
        $this->preferences = implode(',', $preferences);
    }
    return $this;
}

public function removePreference(int $destinationId): static
{
    $preferences = array_filter(
        $this->getPreferencesArray(),
        fn($id) => (int)$id !== $destinationId
    );
    $this->preferences = implode(',', $preferences);
    return $this;
}

public function hasPreference(int $destinationId): bool
{
    return in_array($destinationId, $this->getPreferencesArray());
}

}
