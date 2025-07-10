<?php


namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $dateDebutRapport = null;

    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $dateFinRapport = null;

    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $dateCreationRapport = null;

    #[ORM\Column(type: "string", length: 500)]
    private ?string $contenuRapport = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Journal $journal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutRapport(): ?\DateTimeInterface
    {
        return $this->dateDebutRapport;
    }

    public function setDateDebutRapport(\DateTimeInterface $dateDebutRapport): static
    {
        $this->dateDebutRapport = $dateDebutRapport;
        return $this;
    }

    public function getDateFinRapport(): ?\DateTimeInterface
    {
        return $this->dateFinRapport;
    }

    public function setDateFinRapport(\DateTimeInterface $dateFinRapport): static
    {
        $this->dateFinRapport = $dateFinRapport;
        return $this;
    }

    public function getDateCreationRapport(): ?\DateTimeInterface
    {
        return $this->dateCreationRapport;
    }

    public function setDateCreationRapport(\DateTimeInterface $dateCreationRapport): static
    {
        $this->dateCreationRapport = $dateCreationRapport;
        return $this;
    }

    public function getContenuRapport(): ?string
    {
        return $this->contenuRapport;
    }

    public function setContenuRapport(string $contenuRapport): static
    {
        $this->contenuRapport = $contenuRapport;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getJournal(): ?Journal
    {
        return $this->journal;
    }

    public function setJournal(?Journal $journal): static
    {
        $this->journal = $journal;
        return $this;
    }
}
