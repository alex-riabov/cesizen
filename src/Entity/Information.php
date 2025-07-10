<?php

namespace App\Entity;

use App\Repository\InformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationRepository::class)]
class Information
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomInformation = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateHeureInformation = null;

    #[ORM\Column(length: 500)]
    private ?string $contenuInformation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomInformation(): ?string
    {
        return $this->nomInformation;
    }

    public function setNomInformation(string $nomInformation): self
    {
        $this->nomInformation = $nomInformation;
        return $this;
    }

    public function getDateHeureInformation(): ?\DateTimeInterface
    {
        return $this->dateHeureInformation;
    }

    public function setDateHeureInformation(\DateTimeInterface $dateHeureInformation): self
    {
        $this->dateHeureInformation = $dateHeureInformation;
        return $this;
    }

    public function getContenuInformation(): ?string
    {
        return $this->contenuInformation;
    }

    public function setContenuInformation(string $contenuInformation): self
    {
        $this->contenuInformation = $contenuInformation;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
}